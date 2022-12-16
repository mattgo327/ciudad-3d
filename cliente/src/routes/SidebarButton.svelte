<script>
	export let description;
</script>

<button class="flex flex-col items-center py-2 text-xs text-slate-500 hover:bg-slate-100">
	<slot />
	{description}
</button>
