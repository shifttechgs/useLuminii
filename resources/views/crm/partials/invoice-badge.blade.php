@php
$map = [
    'Draft'         => 'crm-badge-neutral',
    'Sent'          => 'crm-badge-info',
    'PartiallyPaid' => 'crm-badge-warning',
    'Paid'          => 'crm-badge-success',
    'Overdue'       => 'crm-badge-danger',
    'Cancelled'     => 'crm-badge-neutral',
];
$cls = $map[$status] ?? 'crm-badge-neutral';
@endphp
<span class="crm-badge {{ $cls }}"><span class="crm-badge-dot"></span>{{ $status }}</span>

