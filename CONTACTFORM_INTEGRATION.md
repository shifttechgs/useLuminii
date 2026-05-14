# Contact Form API Integration - Laravel Setup

## 📋 Overview

Your Laravel contact form now integrates with the Luminii CRM API to:
- Save all contact form submissions to your CRM database
- Send email notifications to admin
- Provide real-time validation and error handling
- Track lead status and assignments

---

## 🚀 Quick Start

### 1. Environment Configuration

Your `.env` file has been updated with:

```env
# Luminii CRM API Configuration
LUMINII_API_BASE_URL=http://95.217.134.215:5000
LUMINII_API_VERSION=v1
LUMINII_API_TIMEOUT=30

# Admin Email for contact form notifications
ADMIN_EMAIL=info@shifttechgs.com
```

**For Production**: Update `LUMINII_API_BASE_URL` to use HTTPS:
```env
LUMINII_API_BASE_URL=https://api.yourdomain.com
```

### 2. Clear Cache

After updating `.env`, clear the configuration cache:

```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Test the Integration

1. Visit: `http://localhost/contact`
2. Fill out the form
3. Submit
4. Check for success toast notification
5. Verify email received at `info@shifttechgs.com`

---

## 📁 Files Modified/Created

### Created Files

1. **API Service**
   - `app/Services/ContactFormApiService.php`
   - Handles all communication with C# API
   - Includes error handling and logging

2. **Form Request Validator**
   - `app/Http/Requests/ContactFormRequest.php`
   - Server-side validation
   - Data formatting for API

### Modified Files

1. **Controller**
   - `app/Http/Controllers/ContactsController.php`
   - Updated to use API service
   - Returns JSON responses

2. **Routes**
   - `routes/web.php`
   - Added: `POST /contact/submit`

3. **View**
   - `resources/views/contact.blade.php`
   - Added AJAX form submission
   - Added toast notifications
   - Added loading states

4. **Configuration**
   - `config/services.php`
   - Added Luminii API config

5. **Environment**
   - `.env`
   - Added API credentials

---

## 🔌 API Endpoints Used

### Submit Contact Form

**Endpoint**: `POST /api/v1/ContactForm/submitContactForm`

**Request Format**:
```json
{
  "Name": "John Doe",
  "Email": "john@example.com",
  "Phone": "+27 81 234 5678",
  "Company": "Test Company",
  "CompanyStage": "startup",
  "ReferralSource": "google",
  "Budget": 50000,
  "Message": "I need help with...",
  "Services": ["web_development", "mobile_app"]
}
```

**Response (Success)**:
```json
{
  "Success": true,
  "Data": {
    "ContactId": "CON-20260120-ABCD1234",
    "Name": "John Doe",
    "Email": "john@example.com",
    "Status": "New"
  },
  "Message": "Contact form submitted successfully. We'll respond within 24 hours."
}
```

**Response (Error)**:
```json
{
  "Success": false,
  "Errors": ["Email is required", "At least one service must be selected"],
  "Message": "Validation failed"
}
```

---

## ✅ Validation Rules

The form validates:

| Field | Rules |
|-------|-------|
| name | Required, Max: 100 characters |
| email | Required, Valid email, Max: 150 characters |
| phone | Optional, Max: 20 characters |
| company | Optional, Max: 100 characters |
| company_stage | Optional, One of: idea, startup, growth, sme, enterprise |
| referral_source | Optional, One of: google, linkedin, referral, social, portfolio, other |
| budget | Optional, Numeric, Min: 0, Max: 10,000,000 |
| message | Required, Max: 2000 characters |
| services | Required, At least 1 service |

### Valid Service Values

- `web_development`
- `mobile_app`
- `custom_software`
- `mvp_development`
- `ui_ux_design`
- `ai_automation`
- `cloud_devops`
- `consulting`

---

## 🎨 User Experience Features

### 1. Real-Time Feedback

- ✅ Service checkboxes highlight when selected
- ✅ Budget slider updates value in real-time
- ✅ Form validation before submission
- ✅ Loading state during submission

### 2. Toast Notifications

Success notification appears with:
- Green check icon
- Success message
- Auto-dismisses after 5 seconds
- Manual close button

Error notification appears with:
- Red warning icon
- Error details
- Auto-dismisses after 5 seconds
- Manual close button

### 3. Form Reset

After successful submission:
- Form fields clear
- Checkboxes reset
- Budget slider resets to R25,000
- Page scrolls to top

---

## 🔍 Testing

### Manual Test

```bash
# 1. Start Laravel server
php artisan serve

# 2. Visit contact page
open http://localhost:8000/contact

# 3. Fill out form and submit

# 4. Check logs
tail -f storage/logs/laravel.log
```

### API Test (Direct)

```bash
curl -X POST http://localhost:8000/contact/submit \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "phone": "+27 81 234 5678",
    "company": "Test Co",
    "company_stage": "startup",
    "referral_source": "google",
    "budget": 50000,
    "message": "Test message",
    "services": ["web_development"]
  }'
```

---

## 📊 Logging

### Where to Check Logs

```bash
# View recent Laravel logs
tail -100 storage/logs/laravel.log

# Follow logs in real-time
tail -f storage/logs/laravel.log

# Search for errors
grep -i "error" storage/logs/laravel.log

# Search for contact form submissions
grep -i "contact form" storage/logs/laravel.log
```

### What Gets Logged

- Contact form submission attempts
- API request/response data (with sensitive data masked)
- Validation errors
- API connection errors
- System errors

### Log Format

```
[2026-01-20 10:30:00] local.INFO: Submitting contact form to API {"endpoint":"http://95.217.134.215:5000/api/v1/ContactForm/submitContactForm","data":{"Name":"John Doe","Email":"jo***@example.com"}}

[2026-01-20 10:30:01] local.INFO: Contact form submitted successfully {"contact_id":"CON-20260120-ABCD1234","status_code":200}
```

---

## 🔧 Troubleshooting

### Issue: "Unable to connect to CRM API"

**Possible Causes**:
- API server is down
- Incorrect API URL in `.env`
- Network/firewall issues

**Solutions**:
```bash
# Check API is reachable
curl http://95.217.134.215:5000/health

# Verify .env configuration
cat .env | grep LUMINII_API

# Clear config cache
php artisan config:clear
```

### Issue: "Validation errors"

**Possible Causes**:
- Required fields missing
- Invalid email format
- No services selected

**Solutions**:
- Check browser console for JavaScript errors
- Check Laravel logs for validation messages
- Verify all required fields are filled

### Issue: "Email not received"

**Possible Causes**:
- Email configuration in C# API
- SMTP server issues
- Email in spam folder

**Solutions**:
- Check C# API logs
- Verify SMTP settings in `appsettings.json` on API
- Check spam folder
- Test email configuration

### Issue: "CSRF token mismatch"

**Possible Causes**:
- Session expired
- Cache issues

**Solutions**:
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Refresh the page
```

---

## 🚀 Production Deployment

### Pre-Deployment Checklist

- [ ] Update `LUMINII_API_BASE_URL` to production API URL (HTTPS)
- [ ] Update `ADMIN_EMAIL` to production email
- [ ] Test API connectivity from production server
- [ ] Clear and cache configuration
- [ ] Test form submission end-to-end
- [ ] Monitor logs for errors

### Deployment Commands

```bash
# 1. Pull latest code
git pull origin main

# 2. Install/update dependencies
composer install --optimize-autoloader --no-dev

# 3. Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 4. Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Set proper permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 6. Test
curl -I https://yourdomain.com/contact
```

### Environment Variables for Production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

LUMINII_API_BASE_URL=https://api.yourdomain.com
LUMINII_API_VERSION=v1
LUMINII_API_TIMEOUT=30

ADMIN_EMAIL=info@shifttechgs.com
```

---

## 📈 Monitoring

### Key Metrics to Monitor

1. **Form Submission Success Rate**
   ```bash
   grep "Contact form submitted successfully" storage/logs/laravel.log | wc -l
   ```

2. **API Errors**
   ```bash
   grep "API connection error\|API error" storage/logs/laravel.log
   ```

3. **Validation Failures**
   ```bash
   grep "Validation failed" storage/logs/laravel.log
   ```

### Health Check

Create a simple health check endpoint to monitor integration:

```bash
# Test Laravel is running
curl -I https://yourdomain.com

# Test API is reachable from Laravel server
curl http://95.217.134.215:5000/health
```

---

## 🔒 Security

### CSRF Protection

- ✅ CSRF token included in all form submissions
- ✅ Token validated on Laravel side
- ✅ Token automatically refreshed

### Data Validation

- ✅ Client-side validation (JavaScript)
- ✅ Server-side validation (Laravel)
- ✅ API-side validation (C#)

### Sensitive Data

- ✅ Email/phone masked in logs
- ✅ No passwords or tokens stored
- ✅ HTTPS enforced in production

---

## 💡 Best Practices

### 1. Always Use HTTPS in Production

```env
LUMINII_API_BASE_URL=https://api.yourdomain.com  # ✅ Good
LUMINII_API_BASE_URL=http://api.yourdomain.com   # ❌ Bad
```

### 2. Monitor Logs Regularly

```bash
# Set up log rotation
# Add to cron: 0 0 * * * cd /path/to/project && php artisan log:clear
```

### 3. Test After Deployment

```bash
# Always test after deploying
curl -X POST https://yourdomain.com/contact/submit \
  -H "Content-Type: application/json" \
  -d '{"name":"Test",...}'
```

### 4. Keep Dependencies Updated

```bash
# Regularly update
composer update
```

---

## 📞 Support

### If You Need Help

1. **Check Logs First**
   ```bash
   tail -100 storage/logs/laravel.log
   ```

2. **Verify Configuration**
   ```bash
   php artisan config:show services.luminii_api
   ```

3. **Test API Connectivity**
   ```bash
   curl -v http://95.217.134.215:5000/health
   ```

4. **Contact API Team**
   - Provide Laravel logs
   - Provide exact error message
   - Provide steps to reproduce

---

## ✅ Success Checklist

Your integration is working when:

- [ ] Form submits without errors
- [ ] Success toast notification appears
- [ ] Admin receives email
- [ ] Entry appears in CRM database
- [ ] Laravel logs show successful submission
- [ ] No errors in browser console
- [ ] Form resets after submission
- [ ] Contact ID is generated

---

**Last Updated**: 2026-01-20
**Version**: 1.0
**Status**: Production Ready ✅
