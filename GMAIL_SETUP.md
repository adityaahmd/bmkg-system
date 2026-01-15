# Gmail SMTP Setup Guide for BMKG System

This guide explains how to configure Gmail SMTP to send email notifications from the BMKG System.

## Prerequisites

- A Gmail account (personal or Google Workspace)
- Access to Google Account settings
- 2-Factor Authentication (2FA) enabled on your Gmail account

---

## Step 1: Enable 2-Factor Authentication

1. Go to [Google Account Security](https://myaccount.google.com/security)
2. Sign in with your Gmail account
3. Under "Signing in to Google", ensure **2-Step Verification** is ON
   - If not, click "Turn on 2-Step Verification" and follow the prompts

## Step 2: Generate App Password

App Passwords are 16-digit codes that allow apps to access your Google Account.

### Method 1: Through Google Account

1. Go to [App Passwords](https://myaccount.google.com/apppasswords)
   - Or search for "App Passwords" in your Google Account settings
   
2. If prompted, enter your 2-Step Verification code

3. In the "App name" field, enter: `BMKG System`

4. Click **Create**

5. **IMPORTANT**: Copy the 16-character password immediately!
   - Format: `xxxx xxxx xxxx xxxx` (spaces will be included)
   - Example: `abcd efgh ijkl mnop`

6. Store this password safely - you won't be able to see it again!

### Method 2: Alternative Path

If you can't find App Passwords:
1. Go to [Google Account](https://myaccount.google.com)
2. Navigate to **Security** > **2-Step Verification**
3. Scroll down to "App Passwords"
4. Follow steps 3-6 above

## Step 3: Configure .env File

Edit your `.env` file and add/update these mail settings:

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="BMKG Data Service"
```

### Important Notes:

- **MAIL_USERNAME**: Your full Gmail address (e.g., `myname@gmail.com`)
- **MAIL_PASSWORD**: The 16-digit app password you generated (without spaces!)
  - Example: `abcd1234efgh5678` (NOT your Gmail password!)
- **MAIL_FROM_ADDRESS**: Can be different from MAIL_USERNAME
- **MAIL_FROM_NAME**: The name that appears in email clients

## Step 4: Clear Configuration Cache

After updating the `.env` file, clear the Laravel cache:

```bash
php artisan config:clear
php artisan cache:clear
```

## Step 5: Test Email Configuration

### Option A: Using Artisan Tinker

```bash
php artisan tinker
```

Then paste this code:

```php
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use App\Models\Order;

// First create a test order in your database, or use a dummy object
// For testing, just check if config is correct:
dump(config('mail'));
exit;
```

### Option B: Create a Test Route

Add this to `routes/web.php`:

```php
Route::get('/test-email', function () {
    try {
        Mail::raw('Test email from BMKG System', function ($message) {
            $message->to('recipient@example.com')
                    ->subject('Test Email');
        });
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
```

Visit `/test-email` in your browser.

## Troubleshooting

### "Username and Password not accepted" Error

1. **Wrong password**: Make sure you're using the App Password, not your Gmail password
2. **2FA not enabled**: Enable 2-Factor Authentication first
3. **App Password not created**: Create a new App Password

### "Connection Timed Out" Error

1. **Firewall/Antivirus**: Temporarily disable to test
2. **Port blocked**: Contact your hosting provider to unblock port 587
3. **VPN**: Try without VPN

### "Could Not Authenticate" Error

1. Double-check the app password (16 characters)
2. Make sure there are no spaces in the password in `.env`
3. Regenerate a new App Password and try again

### Less Secure Apps Setting

Google has removed the "Less Secure Apps" setting. If you see errors about this:
- Ensure you're using an App Password
- Make sure 2FA is enabled
- Use the correct SMTP settings (smtp.gmail.com, port 587, TLS)

## Security Best Practices

1. **Never commit `.env` to Git**: Add it to `.gitignore`
2. **Use a dedicated email**: Consider creating a dedicated email for system notifications
3. **Regularly rotate passwords**: Generate new App Passwords periodically
4. **Monitor usage**: Check your Gmail sent folder for any unauthorized emails

## Alternative Email Providers

If Gmail doesn't work for you, consider these alternatives:

### Mailgun (Free tier available)
```env
MAIL_MAILER=mailgun
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=your-mailgun-username
MAIL_PASSWORD=your-mailgun-password
```

### SendGrid (Free tier available)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
```

## Support

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify all `.env` settings are correct
3. Ensure no extra spaces in the app password

