@props([
    'variant' => 'primary',   // primary | secondary | ghost | danger
    'size'    => 'md',        // sm | md | lg
    'href'    => null,
    'type'    => 'button',
    'icon'    => null,
    'iconRight' => null,
])

@php
    $cls  = "crm-btn crm-btn-$variant";
    $cls .= $size === 'sm' ? ' crm-btn-sm' : ($size === 'lg' ? ' crm-btn-lg' : '');
    $tag  = $href ? 'a' : 'button';
@endphp

<{{ $tag }}
    {{ $href ? "href=$href" : "type=$type" }}
    {{ $attributes->merge(['class' => $cls]) }}
>
    @if($icon){!! $icon !!}@endif
    {{ $slot }}
    @if($iconRight){!! $iconRight !!}@endif
</{{ $tag }}>
