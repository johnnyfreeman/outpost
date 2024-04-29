@props([])
<a {{ $attributes->class([
	'text-blue-800 no-underline',
]) }}>
	{{ $slot }}
</a>
