@php
    $isDemo = !empty($data['business_type']);
    $name = trim($data['fullname'] ?? '') ?: 'Someone';
@endphp
{{ $isDemo ? 'NEW DEMO REQUEST' : 'NEW WEBSITE ENQUIRY' }}
{{ now()->setTimezone('Africa/Johannesburg')->format('D j M Y, H:i') }} SAST

{{ $isDemo ? "{$name} wants a demo." : "{$name} sent an enquiry." }}

Name:          {{ $name }}
Email:         {{ $data['email'] ?? '-' }}
@if(!empty($data['business_type']))
Business type: {{ $data['business_type'] }}
@endif
@if(!empty($data['team_size']))
Team size:     {{ $data['team_size'] }}
@endif
@if(!empty($data['package']))
Plan:          {{ $data['package'] }}
@endif
@if(!empty($data['current_tools']))
Current tools: {{ $data['current_tools'] }}
@endif

@if($isDemo && !empty($data['pain_point']))
What they want to improve:
{{ $data['pain_point'] }}
@elseif(!empty($data['message']))
Their message:
{{ $data['message'] }}
@endif

@if(!empty($data['crm_url']))
Open in CRM: {{ $data['crm_url'] }}
@endif
Next step: {{ $isDemo ? 'reply to confirm a demo time.' : 'reply to their enquiry.' }} Replying to this email goes straight to {{ strtok($name, ' ') }}.
