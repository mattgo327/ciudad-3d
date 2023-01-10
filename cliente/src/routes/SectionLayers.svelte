<script>
	import { layers } from '../store';

	let layersValue;

	layers.subscribe((value) => {
		layersValue = value;
	});

	function handleCheck(e) {
		let id = parseInt(e.srcElement.id);
		let isChecked = e.srcElement.checked;
		layers.update((value) => {
			value[id].show = isChecked;
			return value;
		});
	}
</script>

<label class="text-sm text-slate-500 ml-6 mt-5 align-middle flex items-center">
	<input
		type="checkbox"
		class="mr-2"
		id="0"
		checked={layersValue[0].show}
		on:click={(e) => {
			handleCheck(e);
		}}
	/>
	<div class="rounded bg-red-600 h-2 w-2 mr-2" />
	Línea oficial
</label>
<label class="text-sm text-slate-500 ml-6 mt-5 align-middle flex items-center">
	<input
		type="checkbox"
		class="mr-2"
		id="1"
		checked={layersValue[1].show}
		on:click={(e) => {
			handleCheck(e);
		}}
	/>
	<div class="rounded bg-red-600 h-2 w-2 mr-2" />
	Rutas principales
</label>
