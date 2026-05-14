@props(['title' => null, 'actions' => null, 'noPad' => false])

<div {{ $attributes->merge(['class' => 'crm-card']) }}>
    @if($title || isset($actions))
    <div class="crm-card-header">
        <h3 class="crm-card-title">{{ $title }}</h3>
        @if(isset($actions))
        <div class="flex items-center gap-2">{{ $actions }}</div>
        @endif
    </div>
    @endif
    <div @class(['crm-card-body' => !$noPad])>{{ $slot }}</div>
</div>
