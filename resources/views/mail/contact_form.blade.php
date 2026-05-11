@component('mail::message')
# New Submission — useLuminii

Hello Team,

A new submission has arrived through the useLuminii website. Here are the details:

---

**Full Name:** {{ $data['fullname'] ?? 'N/A' }}

**Email:** {{ $data['email'] ?? 'N/A' }}

@if(!empty($data['subject']))
**Type:** {{ $data['subject'] }}
@endif

@if(!empty($data['package']))
**Plan:** {{ $data['package'] }}
@endif

@if(!empty($data['business_type']))
**Business Type:** {{ $data['business_type'] }}
@endif

@if(!empty($data['team_size']))
**Team Size:** {{ $data['team_size'] }}
@endif

@if(!empty($data['pain_point']))
**Biggest Pain Point:** {{ $data['pain_point'] }}
@endif

@if(!empty($data['current_tools']))
**Current Tools:** {{ $data['current_tools'] }}
@endif

@if(!empty($data['message']))
**Message:** {{ $data['message'] }}
@endif

---

Respond promptly — the business is ready to move.

Thanks,
The useLuminii Team

@endcomponent
