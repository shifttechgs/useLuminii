{{-- A small version of the homepage "Every workflow" record: the pieces one job carries
     from enquiry to payment. Earlier pieces are dimmed, the newest is lit. Decorative. --}}
@php
    $recordPieces = [
        ['Client',  'Amina D.'],
        ['Quote',   'QUO-1042'],
        ['Job',     'Thu 11:00'],
        ['Invoice', 'INV-1042'],
        ['Payment', 'Paid in full'],
    ];
@endphp
<figure class="lp-su-record" aria-hidden="true">
    <figcaption class="lp-su-record__label">One job record</figcaption>
    <ol class="lp-su-record__pieces">
        @foreach($recordPieces as $i => [$label, $value])
            <li class="{{ $loop->last ? 'is-new' : 'is-carried' }}" style="--i: {{ $i }}">
                <span>{{ $label }}@if($loop->last)<em>New</em>@endif</span>
                <strong>{{ $value }}</strong>
            </li>
        @endforeach
    </ol>
</figure>
