@props(['variant' => 'neutral', 'dot' => true])

<span {{ $attributes->merge(['class' => "crm-badge crm-badge-$variant"]) }}>
    @if($dot)<span class="crm-badge-dot"></span>@endif
    {{ $slot }}
</span>
