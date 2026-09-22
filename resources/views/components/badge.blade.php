@props([
    'type' => null,
    'variant' => null,
    'dot' => false,
])

@php
    $badgeType = $variant ?? $type ?? 'primary';
@endphp

<span {{ $attributes->merge(['class' => 'badge badge-' . $badgeType]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full bg-current opacity-80 shrink-0"></span>
    @endif
    {{ $slot }}
</span>
