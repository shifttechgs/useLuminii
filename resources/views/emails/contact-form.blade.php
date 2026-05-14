<x-mail::message>

<div style="text-align: center; margin-bottom: 30px;">
    <img src="{{ config('app.url') }}/assets/images/logo/logo_dark.png" alt="{{ config('app.name') }}" style="height: 60px; max-width: 200px;">
</div>

# New Contact Form Submission

You have received a new contact form submission from your website.

<x-mail::panel>
## Contact Details

**Name:** {{ $formData['name'] }}
**Email:** {{ $formData['email'] }}
@if(!empty($formData['phone']))
**Phone:** {{ $formData['phone'] }}
@endif
@if(!empty($formData['company']))
**Company:** {{ $formData['company'] }}
@endif
@if(!empty($formData['company_stage']))
**Company Stage:** {{ ucfirst($formData['company_stage']) }}
@endif
</x-mail::panel>

## Services Interested In

@if(!empty($formData['services']))
@foreach($formData['services'] as $service)
- {{ str_replace('_', ' ', ucwords($service, '_')) }}
@endforeach
@endif

@if(!empty($formData['budget']))
## Budget

**Estimated Budget:** R {{ number_format($formData['budget'], 2) }}
@endif

@if(!empty($formData['referral_source']))
## Referral Source

**How they found us:** {{ ucfirst($formData['referral_source']) }}
@endif

## Message

{{ $formData['message'] }}

---

@if($savedToApi)
<x-mail::panel>
✅ **CRM Status:** This contact has been automatically saved to the CRM system.
</x-mail::panel>
@else
<x-mail::panel>
⚠️ **CRM Status:** Unable to save to CRM. Please add this contact manually.
</x-mail::panel>
@endif

<x-mail::button :url="'mailto:' . $formData['email']" color="primary">
Reply to {{ $formData['name'] }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} Website System
</x-mail::message>
