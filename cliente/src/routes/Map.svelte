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

	let layers = [
		{
			url: 'http://localhost:5173/layers/plazacity.geojson',
			json: {},
			mostrar: false
		},
		{
			url: 'http://localhost:5173/layers/routes.geojson',
			json: {},
			mostrar: false
		},
		{
			url: 'http://localhost:5173/layers/casa1.geojson',
			json: {},
			mostrar: false
		},
		{
			url: 'http://localhost:5173/layers/casa2.geojson',
			json: {},
			mostrar: true
		}
	];

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
			opacity: 0,
			fillcolor: 'red',
			fillOpacity: 0,
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

			fetch('http://localhost:5173/layers/casa1.geojson')
				.then((response) => response.json())
				.then((json) => {
					layers[2].json = json;
					if (is_active(2)) {
						leaflet
							.geoJSON(layers[2].json, {
								onEachFeature: popup,
								style: a.default
							})
							.addTo(map);
						change_osmb(layers[2].url);
					}
				});

			fetch('http://localhost:5173/layers/casa2.geojson')
				.then((response) => response.json())
				.then((json) => {
					layers[3].json = json;
					if (is_active(3)) {
						leaflet
							.geoJSON(layers[3].json, {
								onEachFeature: popup,
								style: a.default
							})
							.addTo(map);
						change_osmb(layers[3].url);
					}
				});

			/////////////////////// OSMB ////////////////////////
			change_osmb();
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
					to_do(e);
				} else {
					layer.setStyle(a.default);
					manyselect = 0;
				}
			}
		});
	}

	async function change_osmb(url_ = null) {
		const osmBuildings = (await import('osmbuildings/dist/OSMBuildings-Leaflet')).OSMBuildings;
		if (url_ == null) {
			new osmBuildings(map).load();
		} else {
			new osmBuildings(map).load(url_);
		}
	}

	onDestroy(async () => {
		if (map) {
			map.remove();
		}
	});

	function to_do(ev) {
		section.set(1);
		var feature = ev.target.feature;
		informacionParcela.set(feature.properties);
	}

	function is_active(indice) {
		return layers[indice].mostrar;
	}
</script>

<div class="h-full w-full z-10" bind:this={mapElement} data-for-rerender={layersValue[0].nombre} />

<style>
	@import 'leaflet/dist/leaflet.css';
</style>
