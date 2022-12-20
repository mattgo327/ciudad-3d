<script>
	let layers = [
		{
			nombre: 'Parcela',
			mostrar: true // las parcelas se mostraran por defecto
		},
		{
			nombre: 'Rutas',
			mostrar: false
		}
	];

	function checkbox(element) {
		let id = element.srcElement.id;
		let nombre = layers[parseInt(id)].nombre;
		let mostrar_capa = (layers[parseInt(id)].mostrar = element.srcElement.checked);

		console.log(nombre + ' ' + id + ' ' + mostrar_capa);
	}
</script>

<label class="text-sm text-slate-500 ml-6 mt-5 align-middle flex items-center">
	<input
		type="checkbox"
		class="mr-2"
		id="0"
		checked
		on:click={(e) => {
			checkbox(e);
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
		on:click={(e) => {
			checkbox(e);
		}}
	/>
	<div class="rounded bg-red-600 h-2 w-2 mr-2" />
	Rutas principales
</label>
