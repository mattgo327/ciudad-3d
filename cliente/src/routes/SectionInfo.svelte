<script>
	import { informacionParcela } from '../store';

	let informacion;

	informacionParcela.subscribe((value) => {
		informacion = value;
	});
</script>

{#if informacion}
	<div class="rounded bg-slate-100 py-5 px-2 my-3 mr-3 ml-5 flex justify-between">
		<p class="text-slate-500 text-sm font-semibold">Nombre</p>
		<p class="text-slate-500 text-sm">{informacion.name}</p>
	</div>
	<div class="rounded bg-slate-100 py-5 px-2 my-3 mr-3 ml-5 flex justify-between">
		<p class="text-slate-500 text-sm font-semibold">Descripción</p>
		<p class="text-slate-500 text-sm">{informacion.descripcion}</p>
	</div>
{:else}
	<div class="border rounded-lg text-slate-500 p-10 m-10 ml-12">
		<p class="text-center">Seleccione una parcela</p>
	</div>
{/if}
