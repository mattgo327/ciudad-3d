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

			var a2 = [
				[-25.497032432786852, -54.67801094055176],
				[-25.497032432786852, -54.677742719650276],
				[-25.49725032098642, -54.677726626396186],
				[-25.497269688807265, -54.67795193195344],
				[-25.497032432786852, -54.67801094055176]
			]

			var pol = leaflet.polygon(a2, {
				mouseover: (e) => {
					const layer = e.target;
					console.log(e);
					layer.setStyle({
						fillOpacity: 0.7
					})
				},
				mouseout: (e) => {
					const layer = e.target;
					console.log(e);
					layer.setStyle({
						fillOpacity: 0.7
					})
				}
			}).addTo(map);

			// https://www.youtube.com/watch?v=jW8pfxJEHsg 

			/*map.on("mousemove", (e) => {

				//console.log(e.latlng.lat);

				if (e.latlng.lng > a2[0][1] && e.latlng.lng < a2[1][1] && e.latlng.lat > a2[2][0]){
					//console.log(1);
				}
			});*/

			
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
