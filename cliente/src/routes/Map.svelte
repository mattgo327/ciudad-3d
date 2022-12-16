<script>
	import { onMount, onDestroy } from 'svelte';
	import { browser } from '$app/environment';

	let mapElement;
	let map;
	// <test>
	let select = false;
	let a = {
		selected:{
			color: "red",
			opacity: 100,
			fillcolor:"red",
			fillOpacity:1,
			weight: 0.5
		},
		default:{
			color: "blue",
			opacity: 1,
			fillcolor:"red",
			fillOpacity:0.1,
			weight: 0.5
		}
	}

	let manyselect = 0;
	// </test>
	onMount(async () => {
		if (browser) {
			const leaflet = await import('leaflet');

			map = leaflet.map(mapElement).setView([-25.49765, -54.67885], 1700);

			leaflet
				.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					attribution:
						'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
				})
				.addTo(map);

			leaflet
				.marker([-25.49685812194268, -54.67757642269135])
				.addTo(map)
				.bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
				.openPopup();
			
			/*test*/

			map.on('dblclick',function(e){
				var coord = e;
				console.log(coord.latlng.lat + " " + coord.latlng.lng);
				leaflet.marker([coord.latlng.lat, coord.latlng.lng]).addTo(map);
			});
			
			fetch("http://localhost:5173/layers/plazacity.geojson").then((response) => response.json() )
			.then((json) => {
				leaflet.geoJSON(json)
				.addTo(map);

				var polygonsBlock = leaflet.geoJson(json, {
					onEachFeature: popup,
					style:a.default
				}).addTo(map);
			});
		}
	});

	function popup (feature, layer){
		layer.on({
			click: (e) => {
				select = !select;
				if (select && manyselect == 0){
					layer.setStyle(a.selected);
					manyselect = 1;
					to_do(e, layer, select);
				}else{
					layer.setStyle(a.default);
					manyselect = 0;
				}

			}
		});
		
	}

	onDestroy(async () => {
		if (map) {
			console.log('Unloading Leaflet map.');
			map.remove();
		}
	});

	function to_do(event, layer, is_selected){
		var feature = event.target.feature;
		layer.bindPopup(feature.properties.name);
		
	}

</script>

<div id="map" bind:this={mapElement} />

<style>
	@import 'leaflet/dist/leaflet.css';
	#map {
		width: 800px;
		height: 500px;
	}
</style>
