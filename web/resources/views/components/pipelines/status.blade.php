@props(['event' => null])
<div @class([
	'flex-shrink-0 w-4 h-4 inline-flex items-center justify-center rounded-full',
	'text-gray-400 bg-gray-100' => ! $event?->isComplete(),
	'text-green-600 bg-green-100' => $event?->isSuccess(),
	'text-red-600 bg-red-100' => $event?->isFailure(),
])>
	<div class="h-2 w-2 rounded-full bg-current"></div>
</div>
