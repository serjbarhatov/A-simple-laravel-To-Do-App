<?php

namespace App\Guards;

use App\Services\PasswordService;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class CustomSessionGuard extends SessionGuard
{
    public function __construct($name, UserProvider $provider, Request $request)
    {
        parent::__construct($name, $provider, $request);
    }

    /**
     * Validate a user's credentials.
     */
    public function validate(array $credentials = []): bool
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        if ($user && PasswordService::verify($credentials['password'], $user->password)) {
            // Check if password needs rehashing
            if (PasswordService::needsRehash($user->password)) {
                $user->password = $credentials['password']; // Will be rehashed by mutator
                $user->save();
            }
            
            return true;
        }

        return false;
    }
} 