<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LoginThrottle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $throttleKey = $this->throttleKey($request);
        
        $maxAttempts = config('auth.throttling.login.max_attempts', 5);
        $lockoutMinutes = config('auth.throttling.login.lockout_minutes', 15);
        $decayMinutes = config('auth.throttling.login.decay_minutes', 1);

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            return back()->withErrors([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ])->withInput($request->only('email'));
        }

        RateLimiter::hit($throttleKey, $decayMinutes * 60);

        $response = $next($request);

        if ($response->getStatusCode() === 422) {
            RateLimiter::clear($throttleKey);
        }

        return $response;
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
    }
} 