<script>
	import { onMount, onDestroy } from 'svelte';
	import { browser } from '$app/environment';
	import { informacionParcela, section } from '../store';

	let mapElement;
	let map;

	let manyselect = 0;
	let select = false;

	let layers = [
		{
			url:"http://localhost:5173/layers/plazacity.geojson",
			json:{},
			mostrar: false
		},
		{
			url:"http://localhost:5173/layers/routes.geojson",
			json:{},
			mostrar: false
		},
		{
			url:"http://localhost:5173/layers/casa1.geojson",
			json:{},
			mostrar: false
		},
		{
			url:"http://localhost:5173/layers/casa2.geojson",
			json:{},
			mostrar: true
		}
	]
	
	let a = {
		selected: {
			color: 'red',
			opacity: 100,
			fillcolor: 'red',
			fillOpacity: 1,
			weight: 0.5
		},
		default:{
			color: 'blue',
			opacity: 0,
			fillcolor: 'red',
			fillOpacity: 0,
			weight: 0.5
		}
	};
	onMount(async () => {
		if (browser) {
			/////////////// LEAFLET ////////////////
			const leaflet = await import('leaflet');
			map = leaflet.map(mapElement).setView([-25.49765, -54.67885], 1700);

			leaflet
				.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					attribution:
						'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
				})
				.addTo(map);

			////////////////////// TESTING ////////////////////////
			
			/* 
			leaflet
				.marker([-25.49685812194268, -54.67757642269135])
				.addTo(map)
				.bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
				.openPopup();

			map.on('dblclick', function (e) {
				var coord = e;
				console.log(coord.latlng.lat + ' ' + coord.latlng.lng);
			});
			*/
			
			/////////////////////// FETCH ////////////////////////

			fetch('http://localhost:5173/layers/plazacity.geojson')
				.then((response) => response.json())
				.then((json) => {
					layers[0].json = json;
					if (is_active(0)){
						leaflet.geoJSON(layers[0].json,{
							onEachFeature: popup,
							style: a.default
						}).addTo(map);
						change_osmb(layers[0].url);
					}
				});

			fetch('http://localhost:5173/layers/routes.geojson')
			.then((response) => response.json())
			.then((json) => {
				layers[1].json = json;
				if (is_active(1)) leaflet.geoJSON(layers[1].json).addTo(map);
				
			});

			fetch('http://localhost:5173/layers/casa1.geojson')
			.then((response) => response.json())
			.then((json) => {
				layers[2].json = json;
				if (is_active(2)){
					leaflet.geoJSON(layers[2].json,{
						onEachFeature: popup,
						style: a.default
					}).addTo(map);
					change_osmb(layers[2].url);
				}
			});

			fetch('http://localhost:5173/layers/casa2.geojson')
			.then((response) => response.json())
			.then((json) => {
				layers[3].json = json;
				if (is_active(3)){
					leaflet.geoJSON(layers[3].json,{
						onEachFeature: popup,
						style: a.default
					}).addTo(map);
					change_osmb(layers[3].url);
				}
			});

			/////////////////////// OSMB ////////////////////////
			change_osmb();
			
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

	async function change_osmb(url_=null){
		const osmBuildings = (await import('osmbuildings/dist/OSMBuildings-Leaflet')).OSMBuildings;
		if (url_ == null){
			new osmBuildings(map).load();
		}else{
			new osmBuildings(map).load(url_);
		}
	}

	onDestroy(async () => {
		if (map) {
			console.log('Unloading Leaflet map.');
			map.remove();
		}
	});

	function to_do(ev) {
		section.set(1);
		var feature = ev.target.feature;
		informacionParcela.set(feature.properties);
	}

	function is_active(indice){
		return layers[indice].mostrar
	}
</script>

<div class="h-full w-full z-10" bind:this={mapElement} />

<style>
	@import 'leaflet/dist/leaflet.css';
</style>
