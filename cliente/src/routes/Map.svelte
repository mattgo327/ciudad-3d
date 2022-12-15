<script>
	import { onMount, onDestroy } from 'svelte';
	import { browser } from '$app/environment';

	let mapElement;
	let map;

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
				.marker([-25.49686780588511, -54.67757105827332])
				.addTo(map)
				.bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
				.openPopup();
			
			/*test*/

			/*
			var points = [
				{
					"nombre":"centro",
					"lat":-25.496887173767618,
					"lng":-54.67760860919953
				}
			]

			for (var i = 0;i < points.lenght; i++){
				leaflet
					.marker([points[i].lat, points[i].lng])
					.addTo(map)
					marker.bindPopup(points[i].nombre)
					.openPopup();
			}

			console.log(points[0].lat);

			var marker = new leaflet.marker([-25.49765, -54.67999])
			.addTo(map);
			marker.bindPopup(marker._latlng.lat + " " + marker._latlng.lng); 
			*/

			map.on('dblclick',function(e){
				var coord = e;
				console.log(coord.latlng.lat + " " + coord.latlng.lng);
			});

			fetch("http://localhost:5173/plazacity.geojson").then((response) => response.json() )
			.then((json) => {
				leaflet.geoJSON(json)
				.addTo(map);
			});
			/*test*/
		}
	});

	onDestroy(async () => {
		if (map) {
			console.log('Unloading Leaflet map.');
			map.remove();
		}
	});

</script>

<div id="map" bind:this={mapElement} />

<style>
	@import 'leaflet/dist/leaflet.css';
	#map {
		width: 800px;
		height: 500px;
	}
</style>
