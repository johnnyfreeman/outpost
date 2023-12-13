@props(['agent' => null])
<div @class([
	'flex-shrink-0 w-4 h-4 inline-flex items-center justify-center rounded-full',
	'text-green-600 bg-green-100' => $agent?->isOnline(),
	'text-red-600 bg-red-100' => ! $agent?->isOnline(),
])>
	<div class="h-2 w-2 rounded-full bg-current"></div>
</div>
