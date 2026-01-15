# Todo List: Enable Email Notifications (Gmail SMTP)

## Status: IN PROGRESS

### Phase 1: Environment Configuration (User Action Required)
- [ ] 1.1 Configure Gmail SMTP settings in .env file
      - MAIL_MAILER=smtp
      - MAIL_HOST=smtp.gmail.com
      - MAIL_PORT=587
      - MAIL_USERNAME=your-email@gmail.com
      - MAIL_PASSWORD=your-16-digit-app-password
      - MAIL_ENCRYPTION=tls
      - MAIL_FROM_ADDRESS=your-email@gmail.com
      - MAIL_FROM_NAME="BMKG Data Service"

- [x] 1.2 Update config/mail.php default mailer to 'smtp' ✅ DONE

### Phase 2: Documentation
- [x] 2.1 Create GMAIL_SETUP.md with step-by-step Gmail App Password instructions ✅ DONE

### Phase 3: Testing
- [ ] 3.1 Test email sending with tinker command
- [ ] 3.2 Verify checkout email flow

---

## Completed Tasks ✅

1. ✅ Updated config/mail.php - Changed default mailer from 'log' to 'smtp'
2. ✅ Created GMAIL_SETUP.md - Comprehensive Gmail SMTP setup guide

---

## Next Steps (User Action Required)

### Step 1: Add Gmail Settings to .env File

Open your `.env` file and add these lines at the bottom:

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME="BMKG Data Service"
```

### Step 2: Generate Gmail App Password

Follow the instructions in `GMAIL_SETUP.md`:
1. Enable 2-Factor Authentication on your Gmail account
2. Generate a 16-digit App Password
3. Use that password in MAIL_PASSWORD above

### Step 3: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### Step 4: Test Email

```bash
php artisan tinker
```

Then run:
```php
use Illuminate\Support\Facades\Mail;
Mail::raw('Test email', function($m) { $m->to('test@example.com')->subject('Test'); });
```

---

## Notes
- ✅ The email sending code in CheckoutController.php is already implemented
- ✅ The OrderCreated mailable class is properly configured
- ✅ Email template (created.blade.php) is professional and complete
- ✅ Config/mail.php updated to use 'smtp' as default
- ⚠️ User needs to configure .env file with Gmail credentials

