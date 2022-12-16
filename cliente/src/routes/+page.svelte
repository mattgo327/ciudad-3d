<script>
	import Map from './Map.svelte';
	import Sidebar from './Sidebar.svelte';
	import Section from './Section.svelte';
	import { section } from '../store';

	let sectionValue;

	section.subscribe((value) => {
		sectionValue = value;
	});
</script>

<div class="w-screen h-screen flex">
	<Sidebar />
	{#if sectionValue}
		<Section {sectionValue} />
	{/if}
	<Map />
</div>
