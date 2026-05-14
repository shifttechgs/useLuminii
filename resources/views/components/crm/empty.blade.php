@props(['title' => 'No records found', 'text' => null, 'action' => null])

<div class="crm-empty">
    <div class="crm-empty-icon">
        {{ $icon ?? '' }}
        @if(!isset($icon))
        <svg style="width:1.5rem;height:1.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        @endif
    </div>
    <p class="crm-empty-title">{{ $title }}</p>
    @if($text)<p class="crm-empty-text">{{ $text }}</p>@endif
    @if(isset($action))<div style="margin-top:1rem;">{{ $action }}</div>@endif
</div>
