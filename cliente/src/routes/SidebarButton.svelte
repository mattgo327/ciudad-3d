<script>
	import { section } from '../store';

	export let description, sectionValue;

	const handleClick = () => {
		section.update((value) => {
			if (value) {
				return 0;
			} else {
				return parseInt(sectionValue);
			}
		});
	};
</script>

<button
	on:click={handleClick}
	class="flex flex-col items-center py-2 text-xs text-slate-500 hover:bg-slate-100"
>
	<slot />
	{description}
</button>
