@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-decoration-none'
            : 'text-decoration-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
