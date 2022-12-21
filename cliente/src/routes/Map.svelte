<script>
	import { onMount, onDestroy, afterUpdate } from 'svelte';
	import { browser } from '$app/environment';
	import { informacionParcela, section, layers } from '../store';
	import { assets } from '$app/paths';

	let mapElement;
	let map;
	let layersValue;

	layers.subscribe((value) => {
		layersValue = value;
	});
	// <test>
	let select = false;
	let a = {
		selected: {
			color: 'red',
			opacity: 100,
			fillcolor: 'red',
			fillOpacity: 1,
			weight: 0.5
		},
		default: {
			color: 'blue',
			opacity: 1,
			fillcolor: 'red',
			fillOpacity: 0.1,
			weight: 0.5
		}
	};

	let manyselect = 0;
	let leaflet;
	let layerGroup;
	// </test>
	onMount(async () => {
		if (browser) {
			leaflet = await import('leaflet');
			map = leaflet.map(mapElement).setView([-25.49765, -54.67885], 1700);

			leaflet
				.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					attribution:
						'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
				})
				.addTo(map);

			/*test*/

			layerGroup = new leaflet.LayerGroup();
			layerGroup.addTo(map);

			map.on('dblclick', function (e) {
				var coord = e;
				console.log(coord.latlng.lat + ' ' + coord.latlng.lng);
				//leaflet.marker([coord.latlng.lat, coord.latlng.lng]).addTo(map);
			});

			if (layersValue[0].mostrar) {
				fetch(`${assets}/layers/plazacity.geojson`)
					.then((response) => response.json())
					.then((value) => {
						let plazacityLayer = new leaflet.GeoJSON(value);
						layerGroup.addLayer(plazacityLayer);
						//polygonsBlock
						leaflet
							.geoJson(value, {
								onEachFeature: popup,
								style: a.default
							})
							.addTo(map);
					});
			}

			if (layersValue[1].mostrar) {
				fetch(`${assets}/layers/routes.geojson`)
					.then((response) => response.json())
					.then((value) => {
						// Valor de la segunda capa
						leaflet.geoJSON(value).addTo(map);
						//polygonsBlock
						leaflet
							.geoJson(value, {
								onEachFeature: popup,
								style: a.default
							})
							.addTo(map);
					});
			}

			const osmBuildings = (await import('osmbuildings/dist/OSMBuildings-Leaflet')).OSMBuildings;
			new osmBuildings(map).load();
		}
	});

	let plazacityLayer;
	let routesLayer;
	afterUpdate(async () => {
		if (leaflet) {
			if (layersValue[0].mostrar) {
				if (!plazacityLayer) {
					fetch(`${assets}/layers/plazacity.geojson`)
						.then((response) => response.json())
						.then((value) => {
							plazacityLayer = new leaflet.GeoJSON(value, {
								onEachFeature: popup,
								style: a.default
							});
							layerGroup.addLayer(plazacityLayer);
							//polygonsBlock
							// leaflet
							// .geoJson(value, {
							// 	onEachFeature: popup,
							// 	style: a.default
							// })
							// 	.addTo(map);
						});
				} else if (!layerGroup.hasLayer(plazacityLayer)) {
					layerGroup.addLayer(plazacityLayer);
				}
			} else {
				if (plazacityLayer) {
					layerGroup.removeLayer(plazacityLayer);
				}
			}

			if (layersValue[1].mostrar) {
				if (!routesLayer) {
					fetch(`${assets}/layers/routes.geojson`)
						.then((response) => response.json())
						.then((value) => {
							routesLayer = new leaflet.GeoJSON(value);
							layerGroup.addLayer(routesLayer);
							//polygonsBlock
							// leaflet
							// 	.geoJson(value, {
							// 		onEachFeature: popup,
							// 		style: a.default
							// 	})
							// 	.addTo(map);
						});
				} else if (!layerGroup.hasLayer(routesLayer)) {
					layerGroup.addLayer(routesLayer);
				}
			} else {
				if (routesLayer) {
					layerGroup.removeLayer(routesLayer);
				}
			}
		}
	});

	function popup(feature, layer) {
		layer.on({
			click: (e) => {
				select = !select;
				if (select && manyselect == 0) {
					layer.setStyle(a.selected);
					manyselect = 1;
					to_do(e, layer, select);
				} else {
					layer.setStyle(a.default);
					manyselect = 0;
				}
			}
		});
	}

	onDestroy(async () => {
		if (map) {
			map.remove();
		}
	});

	function to_do(event, layer, is_selected) {
		section.set(1);
		var feature = event.target.feature;
		informacionParcela.set(feature.properties);
	}
</script>

<div class="h-full w-full z-10" bind:this={mapElement} data-for-rerender={layersValue[0].nombre} />

<style>
	@import 'leaflet/dist/leaflet.css';
</style>
