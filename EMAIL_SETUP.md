# Email Setup Guide for Laravel Todo App

## Current Issue
The app is currently configured to use the `log` driver for emails, which means password reset emails are being written to log files instead of being sent to users.

## Solution Options

### Option 1: Use Gmail SMTP (Recommended for Development)

1. **Enable 2-Factor Authentication** on your Gmail account
2. **Generate an App Password**:
   - Go to Google Account settings
   - Security → 2-Step Verification → App passwords
   - Generate a password for "Mail"
3. **Update your .env file**:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Option 2: Use Mailtrap (Safe for Testing)

1. **Sign up at [mailtrap.io](https://mailtrap.io)**
2. **Get your SMTP credentials** from your inbox
3. **Update your .env file**:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Option 3: Use Laravel's Array Driver (For Testing)

This will store emails in memory during the request:

```env
MAIL_MAILER=array
```

### Option 4: Keep Log Driver (Current Setup)

If you want to keep using the log driver, you can view the emails in:
```
storage/logs/laravel.log
```

## Testing Email Functionality

1. **Clear config cache** after changing .env:
   ```bash
   php artisan config:clear
   ```

2. **Test the forgot password flow**:
   - Go to `/forgot-password`
   - Enter a valid email address
   - Check your email (or logs if using log driver)

3. **Check email content** in logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Troubleshooting

### Common Issues:
- **"Connection refused"**: Check if SMTP port is blocked by firewall
- **"Authentication failed"**: Verify username/password for Gmail app passwords
- **"No emails sent"**: Check if MAIL_MAILER is set correctly

### For XAMPP Development:
- Make sure your XAMPP is running
- If using local SMTP, configure XAMPP's Mercury mail server
- Or use external SMTP services (Gmail, Mailtrap, etc.)

## Quick Fix for Development

If you just want to see the emails working quickly, use Mailtrap:

1. Sign up at mailtrap.io (free)
2. Copy the SMTP settings to your .env
3. Test the forgot password functionality
4. Check your Mailtrap inbox for the emails

This way you can see the actual email content without sending real emails. 