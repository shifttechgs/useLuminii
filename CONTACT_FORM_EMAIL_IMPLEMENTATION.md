# Contact Form Email & API Implementation

## Overview
The contact form now supports **dual submission**: sending email notifications to admin AND saving to the Luminii CRM API when available.

## What Was Implemented

### ✅ 1. Email Notifications (Always Sent)
- **Admin email notifications** are sent for every form submission
- Uses Laravel Mail with configured SMTP settings from `.env`
- Professional email template with all form data
- Email is sent to `CONTACT_EMAIL` (sales@shifttechgs.com)

### ✅ 2. API Integration (Optional)
- Attempts to save contact form data to Luminii CRM API
- **Non-blocking**: If API is down, email is still sent
- Email includes status of whether data was saved to CRM

### ✅ 3. Graceful Degradation
- **API Available + Email Success** = Best case scenario
- **API Down + Email Success** = User submission accepted, email sent to admin
- **API Available + Email Failed** = Data saved to CRM, but admin not notified (logged)
- **Both Failed** = Error returned to user

## Files Created/Modified

### New Files:
1. **`app/Mail/ContactFormNotification.php`**
   - Mailable class for admin notifications
   - Passes form data and API status to email template

2. **`resources/views/emails/contact-form.blade.php`**
   - Professional email template using Laravel's Markdown components
   - Shows all form fields, services, budget, and message
   - Includes CRM save status indicator
   - Quick reply button to respond to contact

### Modified Files:
1. **`app/Http/Controllers/ContactsController.php`**
   - Added email notification logic
   - Made API submission non-blocking
   - Enhanced error handling for both email and API failures
   - Added comprehensive logging

## Configuration

### Email Settings (.env)
```env
# Application URL (required for logo in emails)
APP_URL=http://localhost  # Update to https://shifttechgs.com in production

# SMTP Configuration
MAIL_MAILER=smtp
MAIL_HOST=aab.managing.services
MAIL_PORT=465
MAIL_USERNAME=sales@shifttechgs.com
MAIL_PASSWORD=briannacharity@2023
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="sales@shifttechgs.com"
MAIL_FROM_NAME="ShiftTech Global Services"

# Admin notification email
CONTACT_EMAIL=sales@shifttechgs.com
```

**⚠️ Important for Production:**
- Update `APP_URL` to your actual domain (e.g., `https://shifttechgs.com`)
- This ensures the logo displays correctly in emails

### API Settings (.env)
```env
# Luminii CRM API Configuration
LUMINII_API_BASE_URL=https://localhost:5001
LUMINII_API_VERSION=v1
LUMINII_API_TIMEOUT=30
LUMINII_API_VERIFY_SSL=false
```

## How It Works

### Submission Flow:
```
1. User submits contact form
   ↓
2. Validate form data (ContactFormRequest)
   ↓
3. Try to save to Luminii CRM API
   ├─ Success: Mark as saved, get Contact ID
   └─ Failure: Log warning, continue
   ↓
4. Send email notification to admin
   ├─ Include form data
   └─ Include API save status
   ↓
5. Return JSON response
   ├─ Success message
   ├─ Contact ID (if saved to API)
   └─ CRM status
```

### Email Content:
The admin receives a formatted email with:
- **Company Logo**: ShiftTechGS logo at the top (logo_dark.png)
- **Contact Details**: Name, Email, Phone, Company
- **Company Stage**: Idea/Startup/Growth/SME/Enterprise
- **Services Interested In**: List of selected services
- **Budget**: Estimated project budget
- **Referral Source**: How they found the company
- **Message**: Full inquiry text
- **CRM Status**: ✅ Saved to CRM or ⚠️ Manual entry needed
- **Reply Button**: Direct mailto link to respond

## Testing

### Test Email (Without API):
1. Stop the Luminii API
2. Submit a contact form
3. Check that email is received at `CONTACT_EMAIL`
4. Email should show: "⚠️ CRM Status: Unable to save to CRM"

### Test Email + API:
1. Start the Luminii API
2. Submit a contact form
3. Check that:
   - Email is received
   - Email shows: "✅ CRM Status: This contact has been automatically saved"
   - Data appears in CRM database

### Test SMTP Connection:
```bash
php artisan tinker
# In tinker:
Mail::raw('Test email from ShiftTech', function($msg) {
    $msg->to('sales@shifttechgs.com')->subject('Test');
});
```

## Logging

All contact form submissions are logged:

### Success Cases:
```
[INFO] Contact form saved to API
[INFO] Contact form email sent to admin
```

### Failure Cases:
```
[WARNING] Failed to save contact form to API
[WARNING] API connection failed, proceeding with email only
[ERROR] Failed to send contact form email
```

### Log Location:
- Development: `storage/logs/laravel.log`
- Check logs for troubleshooting email/API issues

## Error Handling

### Scenario Matrix:

| API Status | Email Status | Result |
|-----------|-------------|--------|
| ✅ Success | ✅ Success | Best case - data saved & admin notified |
| ❌ Failed | ✅ Success | Data not saved, but admin gets email to add manually |
| ✅ Success | ❌ Failed | Data saved to CRM, but admin not notified (check logs) |
| ❌ Failed | ❌ Failed | Error returned to user, data lost |

## Maintenance

### Update Admin Email:
Change `CONTACT_EMAIL` in `.env` file

### Update Email Template:
Edit `resources/views/emails/contact-form.blade.php`

### Add Email Recipients (CC/BCC):
Modify `ContactsController.php`:
```php
Mail::to($adminEmail)
    ->cc('sales@example.com')
    ->bcc('backup@example.com')
    ->send(new ContactFormNotification($formData, $savedToApi));
```

### Queue Emails (For Better Performance):
1. Set up queue worker
2. Implement `ShouldQueue` interface in `ContactFormNotification.php`
3. Change to: `Mail::to($adminEmail)->queue(...)`

## Security Notes

⚠️ **Important**:
- Email password is stored in `.env` - ensure `.env` is in `.gitignore`
- Never commit credentials to version control
- Use environment-specific `.env` files for production
- Consider using Laravel's encrypted `.env` for sensitive data

## API Backend (C# Implementation)

The contact form API endpoint in the Luminii CRM:
- **Endpoint**: `POST /api/v1/ContactForm/submitContactForm`
- **Returns**: ContactId, timestamp, status
- **Sends Email**: The C# API also sends its own email notifications (configured separately)

Both Laravel and C# API can send emails, providing redundancy.
