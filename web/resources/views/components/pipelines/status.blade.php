@props(['status' => collect(['gray', 'amber', 'green', 'red'])->random()])
<div @class([
	'flex-shrink-0 w-4 h-4 inline-flex items-center justify-center rounded-full',
	'text-amber-600 bg-amber-100' => $status == 'amber',
	'text-gray-400 bg-gray-100' => $status == 'gray',
	'text-green-600 bg-green-100' => $status == 'green',
	'text-red-600 bg-red-100' => $status == 'red',
])>
	<div class="h-2 w-2 rounded-full bg-current"></div>
</div>
