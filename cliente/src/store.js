import { writable } from 'svelte/store';

export const section = writable(0);
export const informacionParcela = writable(null);
export const layers = writable([
	{
		nombre: 'Parcela',
		mostrar: false
	},
	{
		nombre: 'Rutas',
		mostrar: false
	}
]);
