@props([
    'label'  => '',
    'value'  => '0',
    'meta'   => null,
    'icon'   => null,
    'trend'  => null,   // 'up' | 'down' | null
    'href'   => null,
])

@php $tag = $href ? 'a' : 'div'; @endphp

<{{ $tag }} {{ $href ? "href=$href" : '' }} class="crm-stat" style="{{ $href ? 'text-decoration:none;' : '' }}">
    @if($icon)
    <div class="crm-stat-icon">
        {!! $icon !!}
    </div>
    @endif
    <p class="crm-stat-label">{{ $label }}</p>
    <p class="crm-stat-value">{{ $value }}</p>
    @if($meta)
    <p class="crm-stat-meta">
        @if($trend === 'up')
            <svg style="width:0.875rem;height:0.875rem;color:#12b76a;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
        @elseif($trend === 'down')
            <svg style="width:0.875rem;height:0.875rem;color:#f04438;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
        @endif
        {{ $meta }}
    </p>
    @endif
</{{ $tag }}>
