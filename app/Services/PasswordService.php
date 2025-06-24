<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordService
{
    /**
     * Hash a password with additional salt for rainbow table protection
     */
    public static function hash(string $password): string
    {
        // Generate a unique salt for each password
        $salt = Str::random(32);
        
        // Combine password with salt and hash
        $saltedPassword = $password . $salt;
        $hashedPassword = Hash::make($saltedPassword);
        
        // Store salt with hash (separated by dot)
        return $hashedPassword . '.' . $salt;
    }

    /**
     * Verify a password against a stored hash
     */
    public static function verify(string $password, string $hashedPassword): bool
    {
        // Split hash and salt
        $parts = explode('.', $hashedPassword);
        
        if (count($parts) !== 2) {
            // Legacy password without salt, use standard verification
            return Hash::check($password, $hashedPassword);
        }
        
        [$hash, $salt] = $parts;
        
        // Reconstruct salted password and verify
        $saltedPassword = $password . $salt;
        return Hash::check($saltedPassword, $hash);
    }

    /**
     * Check if a password needs to be rehashed
     */
    public static function needsRehash(string $hashedPassword): bool
    {
        $parts = explode('.', $hashedPassword);
        
        if (count($parts) !== 2) {
            // Legacy password, needs rehash
            return true;
        }
        
        [$hash, $salt] = $parts;
        return Hash::needsRehash($hash);
    }

    /**
     * Rehash a password if needed
     */
    public static function rehashIfNeeded(string $password, string $hashedPassword): string
    {
        if (self::needsRehash($hashedPassword)) {
            return self::hash($password);
        }
        
        return $hashedPassword;
    }
} 