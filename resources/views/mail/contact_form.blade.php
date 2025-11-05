@component('mail::message')
    # 💡 New Partnership Inquiry — useLuminii

    Hello Team,

    A new partner inquiry has just been submitted through useLuminii.com,
    Here are the details:

    ---

  # Full Name:
    {{ $data['fullname'] ?? 'N/A' }}

  # Email Address:
    {{ $data['email'] ?? 'N/A' }}

   # Plan Interested In:
    {{ $data['package'] ?? 'N/A' }}

  # Message:
    {{ $data['message'] ?? 'No message provided.' }}

    ---

    ✨ Let’s keep the momentum — respond promptly to continue building meaningful partnerships.


    Thanks & Regards,
    The useLuminii Team
    www.useluminii.com

@endcomponent
