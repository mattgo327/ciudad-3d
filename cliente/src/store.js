import { writable } from 'svelte/store';

export const section = writable(0);
export const informacionParcela = writable(null);
export const layers = writable([
	{
		name: 'plazacity',
		show: false,
		style: {
			color: 'blue',
			opacity: 0.5,
			fillcolor: 'red',
			fillOpacity: 0,
			weight: 0.5
		}
	},
	{
		name: 'routes',
		show: false,
		style: null
	}
]);
