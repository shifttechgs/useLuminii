@props(['title', 'subtitle' => null, 'actions' => null])

<div class="crm-page-header">
    <div>
        <h1 class="crm-page-title">{{ $title }}</h1>
        @if($subtitle)
        <p class="crm-page-subtitle">{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($actions))
    <div class="flex items-center gap-2 flex-shrink-0">{{ $actions }}</div>
    @endif
</div>
