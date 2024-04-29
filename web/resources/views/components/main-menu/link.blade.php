@props(['active' => false])
<a {{ $attributes->class([
	'inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium',
	'border-black text-gray-900' => $active,
	'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => !$active,
]) }}>{{ $slot }}</a>
