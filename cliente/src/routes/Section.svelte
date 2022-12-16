<script>
	let selected = 1;
</script>

<div class="absolute left-16 z-20 flex h-full w-80 flex-col bg-white">
	<div class="shadow flex mb-3">
		<!-- <svg
			class="w-3 fill-slate-500 ml-5 mr-2"
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 448 512"
		>
			<path
				d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"
			/></svg
		> -->
		<h1 class="my-4 font-medium text-slate-500 ml-5">Datos básicos</h1>
	</div>

	<!-- En caso de no haber parcela seleccionada -->
	{#if selected === 1}
		<div class="border rounded-lg text-slate-500 p-10 m-10 ml-12">
			<p class="text-center">Seleccione una parcela</p>
		</div>
	{/if}

	<!-- Datos de parcela seleccionada -->
	<!-- <div class="rounded bg-slate-100 py-5 px-2 my-3 mr-3 ml-5 flex justify-between">
    <p class="text-slate-500 text-sm font-semibold">Dirección</p>
    <p class="text-slate-500 text-sm">San Sebastián</p>
  </div>
  <div class="rounded bg-slate-100 py-5 px-2 my-3 mr-3 ml-5 flex justify-between">
    <p class="text-slate-500 text-sm font-semibold">Dirección</p>
    <p class="text-slate-500 text-sm">San Sebastián</p>
  </div> -->

	<!-- Normativas -->
	<!-- <div class="hover:bg-slate-200 cursor-pointer rounded border-l-4 border-orange-500 bg-slate-100 m-2 ml-5 py-3 text-lg">
    <p class="ml-3 text-slate-500">Catastro</p>
  </div>
  <div class="hover:bg-slate-200 cursor-pointer rounded border-l-4 border-red-500 bg-slate-100 m-2 ml-5 py-3 text-lg">
    <p class="ml-3 text-slate-500">Manuales e Instructivos</p>
  </div> -->

	<!-- Links de Normativa -->
	<!-- <a href="twitter.com" class="text-blue-600 hover:text-blue-800 ml-7 mt-2">Ley de Catastro</a>
  <a href="twitter.com" class="text-blue-600 hover:text-blue-800 ml-7 mt-2">Ley de Catastro</a>
  <a href="twitter.com" class="text-blue-600 hover:text-blue-800 ml-7 mt-2">Ley de Catastro</a> -->

	<!-- Capas -->
	<!-- <label class="text-sm text-slate-500 ml-6 mt-5 align-middle flex items-center">
    <input type="checkbox" class="mr-2"></input>
    <div class="rounded bg-red-600 h-2 w-2 mr-2"></div>
      Línea oficial
  </label> -->
</div>
