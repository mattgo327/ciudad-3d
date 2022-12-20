<script>
	import InfoSection from './SectionInfo.svelte';
	import GuideSection from './SectionGuides.svelte';
	import LayersSection from './SectionLayers.svelte';

	export let sectionTitle,
		sectionValue = 0;
</script>

<div class="absolute left-16 z-20 flex h-full w-80 flex-col bg-white">
	<div class="shadow flex mb-3">
		<h1 class="my-4 font-medium text-slate-500 ml-7">{sectionTitle}</h1>
	</div>

	{#if sectionValue === 1}
		<InfoSection />
	{:else if sectionValue === 2}
		<LayersSection />
	{:else if sectionValue === 3}
		<GuideSection />
	{/if}

	<!-- Links de Normativa -->
	<!-- <a href="twitter.com" class="text-blue-600 hover:text-blue-800 ml-7 mt-2">Ley de Catastro</a>
  <a href="twitter.com" class="text-blue-600 hover:text-blue-800 ml-7 mt-2">Ley de Catastro</a>
  <a href="twitter.com" class="text-blue-600 hover:text-blue-800 ml-7 mt-2">Ley de Catastro</a> -->
</div>
