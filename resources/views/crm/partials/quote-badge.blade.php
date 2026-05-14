@php
$map = [
    'Draft'         => 'crm-badge-neutral',
    'Sent'          => 'crm-badge-info',
    'Accepted'      => 'crm-badge-success',
    'Declined'      => 'crm-badge-danger',
    'Expired'       => 'crm-badge-warning',
];
$cls = $map[$status] ?? 'crm-badge-neutral';
@endphp
<span class="crm-badge {{ $cls }}"><span class="crm-badge-dot"></span>{{ $status }}</span>

