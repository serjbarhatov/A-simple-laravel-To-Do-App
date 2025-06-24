# Security Features Documentation

## Overview
This todo application implements comprehensive security measures to protect user accounts and data.

## Password Security

### Strong Password Requirements
- **Minimum Length**: 12 characters (configurable via `PASSWORD_MIN_LENGTH`)
- **Character Requirements**:
  - At least one uppercase letter
  - At least one lowercase letter
  - At least one number
  - At least one special character
- **Additional Checks**:
  - Prevents common passwords (password, 123456, etc.)
  - Prevents sequential characters (abc, 123, qwe, etc.)
  - Prevents repeated characters (aaa, 111, etc.)

### Rainbow Table Protection
- **Custom Password Service**: Uses additional 32-character salt
- **Unique Salt per Password**: Each password gets a unique salt
- **Backward Compatibility**: Supports legacy passwords without salt
- **Automatic Rehashing**: Upgrades old password hashes when users log in

## Login Security

### Brute Force Protection
- **Configurable Throttling**: 
  - Max attempts: 5 (configurable via `LOGIN_MAX_ATTEMPTS`)
  - Lockout duration: 15 minutes (configurable via `LOGIN_LOCKOUT_MINUTES`)
  - Decay time: 1 minute (configurable via `LOGIN_DECAY_MINUTES`)
- **IP + Email Tracking**: Throttling based on both IP and email
- **Automatic Unlock**: Users can retry after lockout period

### Password Reset Security
- **Rate Limiting**: 3 attempts per 30 minutes
- **Secure Tokens**: Time-limited reset tokens
- **Strong Password Enforcement**: Reset passwords must meet same requirements

## User Experience Security

### Password Manager Encouragement
- **Visual Prompts**: Security tips encouraging password manager usage
- **Recommended Tools**: Bitwarden, 1Password, LastPass
- **Real-time Feedback**: Password strength indicator during registration

### Security Indicators
- **Password Strength Meter**: Visual feedback on password strength
- **Real-time Validation**: Immediate feedback on password requirements
- **Clear Error Messages**: User-friendly security error messages

## Configuration

### Environment Variables
```env
# Login Throttling
LOGIN_MAX_ATTEMPTS=5
LOGIN_LOCKOUT_MINUTES=15
LOGIN_DECAY_MINUTES=1

# Password Reset Throttling
PASSWORD_RESET_MAX_ATTEMPTS=3
PASSWORD_RESET_LOCKOUT_MINUTES=30
PASSWORD_RESET_DECAY_MINUTES=1

# Password Requirements
PASSWORD_MIN_LENGTH=12
PASSWORD_REQUIRE_UPPERCASE=true
PASSWORD_REQUIRE_LOWERCASE=true
PASSWORD_REQUIRE_NUMBERS=true
PASSWORD_REQUIRE_SYMBOLS=true
PASSWORD_PREVENT_COMMON=true
PASSWORD_PREVENT_SEQUENTIAL=true
PASSWORD_PREVENT_REPEATED=true
```

## Implementation Details

### Custom Password Service
- **Location**: `app/Services/PasswordService.php`
- **Features**: Salt generation, verification, rehashing
- **Integration**: Used by User model and authentication

### Strong Password Rule
- **Location**: `app/Rules/StrongPassword.php`
- **Usage**: Applied to registration and password reset
- **Validation**: Comprehensive password strength checking

### Login Throttling Middleware
- **Location**: `app/Http/Middleware/LoginThrottle.php`
- **Registration**: `bootstrap/app.php`
- **Application**: Applied to login POST route

### Custom Session Guard
- **Location**: `app/Guards/CustomSessionGuard.php`
- **Purpose**: Enhanced authentication with custom password verification
- **Features**: Automatic password rehashing

## Security Best Practices

1. **Never store plain text passwords**
2. **Use unique salts for each password**
3. **Implement rate limiting on authentication endpoints**
4. **Provide clear feedback on security requirements**
5. **Encourage password manager usage**
6. **Regular security audits and updates**
7. **Monitor for suspicious login patterns**

## Testing Security Features

### Password Strength Testing
```bash
# Test with weak passwords
curl -X POST /register -d "password=weak"

# Test with strong passwords
curl -X POST /register -d "password=StrongPass123!"
```

### Throttling Testing
```bash
# Test login throttling
for i in {1..10}; do
  curl -X POST /login -d "email=test@example.com&password=wrong"
done
```

## Monitoring and Logging

- **Failed Login Attempts**: Logged for security monitoring
- **Password Reset Requests**: Tracked for abuse detection
- **Account Lockouts**: Monitored for potential attacks
- **Password Changes**: Logged for audit trail

## Future Enhancements

1. **Two-Factor Authentication (2FA)**
2. **Account Lockout Notifications**
3. **Suspicious Activity Detection**
4. **Password Breach Checking**
5. **Session Management**
6. **Security Headers Implementation** 