<script>
	import Map from './Map.svelte';
	import Sidebar from './Sidebar.svelte';
	import Section from './Section.svelte';
	import { section } from '../store';
	import '../app.css';

	let sectionValue;

	const titles = ['Datos básicos', 'Capas', 'Normativas'];

	section.subscribe((value) => {
		sectionValue = value;
	});
</script>

<div class="w-screen h-screen flex">
	<Sidebar />
	{#if sectionValue}
		<Section sectionTitle={titles[sectionValue - 1]} {sectionValue} />
	{/if}
	<Map />
</div>
