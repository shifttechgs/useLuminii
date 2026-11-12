<x-mail::message>
<div style="text-align: center; margin-bottom: 24px;">
<img src="{{ $logoUrl }}" alt="useLuminii" style="height: 40px; max-width: 180px;">
</div>

# You're on the list

Hi{{ $name ? ' '.$name : '' }},

Thanks for using the free useLuminii quote and invoice maker. We'll email you as soon as you can **send quotes and invoices as a link**: your client accepts or pays online, and you see when they open it.

@if($vote)
You voted for **{{ $vote }}** to be built first. Thank you, it helps us decide what to work on.
@endif

Until then, the maker stays free. Keep creating quotes and invoices and downloading them as PDFs.

<x-mail::button :url="$builderUrl">
Make a quote or invoice
</x-mail::button>

Your drafts stay in your browser. We only keep your email, your vote and a short summary of your draft. See our [privacy policy]({{ $privacyUrl }}). If you didn't sign up, or want your details removed, just reply to this email.

Thanks,<br>
The useLuminii team
</x-mail::message>
