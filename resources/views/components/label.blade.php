@props(['value'])

<label {{ $attributes->merge(['class' => 'small text-muted']) }}>
    {{ $value ?? $slot }}
</label>
