<script>
	import { onMount, afterUpdate } from 'svelte';
	import { browser } from '$app/environment';
	import { informacionParcela, section, layers } from '../store';
	import { assets } from '$app/paths';

	let mapElement;
	let map;
	let layersValue;
	const baseLayerStyle = {
		default: {
			color: 'blue',
			opacity: 0.5,
			fillcolor: 'red',
			fillOpacity: 0,
			weight: 0.5
		}
	};

	let leaflet;
	let layerGroup;
	let plazacityLayer;
	let routesLayer;

	layers.subscribe((value) => {
		layersValue = value;
	});

	onMount(async () => {
		if (browser) {
			leaflet = await import('leaflet');
			map = leaflet.map(mapElement).setView([-25.49765, -54.67885], 1700, 80);

			leaflet
				.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					attribution:
						'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
				})
				.addTo(map);

			layerGroup = new leaflet.LayerGroup();
			layerGroup.addTo(map);
			if (layersValue[0].mostrar) {
				if (!plazacityLayer) {
					fetch(`${assets}/layers/plazacity.geojson`)
						.then((response) => response.json())
						.then((data) => {
							plazacityLayer = new leaflet.GeoJSON(data, {
								onEachFeature: onFeatureClick,
								style: baseLayerStyle.default
							});
							layerGroup.addLayer(plazacityLayer);
						});
				} else if (!layerGroup.hasLayer(plazacityLayer)) {
					layerGroup.addLayer(plazacityLayer);
				}
			} else {
				if (plazacityLayer) {
					layerGroup.removeLayer(plazacityLayer);
				}
			}
		}
	});

	afterUpdate(async () => {
		if (leaflet) {
			if (layersValue[0].mostrar) {
				if (!plazacityLayer) {
					fetch(`${assets}/layers/plazacity.geojson`)
						.then((response) => response.json())
						.then((data) => {
							plazacityLayer = new leaflet.GeoJSON(data, {
								onEachFeature: onFeatureClick,
								style: baseLayerStyle.default
							});
							layerGroup.addLayer(plazacityLayer);
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

	function onFeatureClick(feature, layer) {
		layer.on({
			click: (e) => {
				section.set(1);
				const properties = e.target.feature.properties;
				informacionParcela.set(properties);
				loadModel(properties.name);
			}
		});
	}

	const loadModel = async (name) => {
		const osmBuildings = (await import('osmbuildings/dist/OSMBuildings-Leaflet')).OSMBuildings;
		new osmBuildings(map).load(`${assets}/layers/${name}.geojson`);
	};
</script>

<div class="h-full w-full z-10" bind:this={mapElement} data-for-rerender={layersValue[0].nombre} />

<style>
	@import 'leaflet/dist/leaflet.css';
</style>
