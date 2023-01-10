<script>
	import { onMount, afterUpdate } from 'svelte';
	import { browser } from '$app/environment';
	import { informacionParcela, section, layers } from '../store';
	import { assets } from '$app/paths';

	let mapElement;
	let map;
	let layersValue;
	let leaflet;
	let layerGroup;
	let layerObjects = [null, null];

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
		}
	});

	const updateLayer = async (index, onFeatureClick = null) => {
		const { show, name, style } = layersValue[index];
		if (show) {
			if (!layerObjects[index]) {
				fetch(`${assets}/layers/${name}.geojson`)
					.then((response) => response.json())
					.then((data) => {
						layerObjects[index] = new leaflet.GeoJSON(data, {
							onEachFeature: onFeatureClick,
							style
						});
						layerGroup.addLayer(layerObjects[index]);
					});
			} else if (!layerGroup.hasLayer(layerObjects[index])) {
				layerGroup.addLayer(layerObjects[index]);
			}
		} else {
			if (layerObjects[index]) {
				layerGroup.removeLayer(layerObjects[index]);
			}
		}
	};

	afterUpdate(async () => {
		if (leaflet) {
			updateLayer(0, onFeatureClick);
			updateLayer(1);
		}
	});

	const onFeatureClick = (feature, layer) => {
		layer.on({
			click: (e) => {
				section.set(1);
				const properties = e.target.feature.properties;
				informacionParcela.set(properties);
				loadModel(properties.name);
			}
		});
	};

	const loadModel = async (name) => {
		const osmBuildings = (await import('osmbuildings/dist/OSMBuildings-Leaflet')).OSMBuildings;
		new osmBuildings(map).load(`${assets}/layers/${name}.geojson`);
	};
</script>

<div class="h-full w-full z-10" bind:this={mapElement} data-for-rerender={layersValue[0].nombre} />

<style>
	@import 'leaflet/dist/leaflet.css';
</style>
