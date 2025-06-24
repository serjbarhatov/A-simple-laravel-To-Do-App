<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $password = $value;

        // Check minimum length (12 characters)
        if (strlen($password) < 12) {
            $fail('The password must be at least 12 characters long.');
            return;
        }

        // Check for uppercase letters
        if (!preg_match('/[A-Z]/', $password)) {
            $fail('The password must contain at least one uppercase letter.');
            return;
        }

        // Check for lowercase letters
        if (!preg_match('/[a-z]/', $password)) {
            $fail('The password must contain at least one lowercase letter.');
            return;
        }

        // Check for numbers
        if (!preg_match('/[0-9]/', $password)) {
            $fail('The password must contain at least one number.');
            return;
        }

        // Check for special characters
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $fail('The password must contain at least one special character.');
            return;
        }

        // Check for common weak passwords
        $commonPasswords = [
            'password', '123456', '123456789', 'qwerty', 'abc123', 'password123',
            'admin', 'letmein', 'welcome', 'monkey', 'dragon', 'master', 'hello',
            'freedom', 'whatever', 'qazwsx', 'trustno1', 'jordan', 'harley',
            'ranger', 'iwantu', 'jennifer', 'hunter', 'buster', 'soccer',
            'baseball', 'tiger', 'charlie', 'andrew', 'michelle', 'love',
            'sunshine', 'jessica', 'asshole', '696969', 'amanda', 'access',
            'yankees', '987654321', 'dallas', 'austin', 'thunder', 'taylor',
            'matrix', 'mobilemail', 'mom', 'monitor', 'monitoring', 'montana',
            'moon', 'moscow', 'mother', 'movie', 'mozilla', 'music', 'mustang',
            'password', 'pa$$w0rd', 'p@ssw0rd', 'p@$$w0rd', 'pass123', 'pass1234',
            'password1', 'password12', 'password123', 'password1234'
        ];

        if (in_array(strtolower($password), $commonPasswords)) {
            $fail('This password is too common. Please choose a more unique password.');
            return;
        }

        // Check for sequential characters (e.g., 123, abc, qwe)
        if (preg_match('/(?:abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz|123|234|345|456|567|678|789|012|qwe|wer|ert|rty|tyu|yui|uio|iop|asd|sdf|dfg|fgh|ghj|hjk|jkl|zxc|xcv|cvb|vbn|bnm)/i', $password)) {
            $fail('The password contains sequential characters which are not secure.');
            return;
        }

        // Check for repeated characters (e.g., aaa, 111)
        if (preg_match('/(.)\1{2,}/', $password)) {
            $fail('The password contains too many repeated characters.');
            return;
        }
    }
} 