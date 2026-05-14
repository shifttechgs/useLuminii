@php
$map = [
    'New'        => 'crm-badge-info',
    'Scheduled'  => 'crm-badge-info',
    'InProgress' => 'crm-badge-warning',
    'Completed'  => 'crm-badge-success',
    'Cancelled'  => 'crm-badge-danger',
];
$cls = $map[$status] ?? 'crm-badge-neutral';
@endphp
<span class="crm-badge {{ $cls }}"><span class="crm-badge-dot"></span>{{ $status }}</span>

