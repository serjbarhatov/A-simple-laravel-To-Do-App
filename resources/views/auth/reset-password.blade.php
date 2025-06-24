<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Todo App') }} - Set New Password</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50 flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full shadow-lg mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Set New Password</h1>
                <p class="text-gray-600">Choose a strong, secure password</p>
            </div>

            <!-- Reset Form -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-2xl p-8">
                <!-- Security Info -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-green-800 mb-1">✅ Secure Reset Link</h4>
                            <p class="text-sm text-green-700">Your reset link is valid. Please set a new strong password for your account.</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                               readonly>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input id="password" type="password" name="password" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                               placeholder="Enter your new password">
                        <div id="password-strength" class="mt-2 hidden">
                            <div class="flex space-x-1 mb-2">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="strength-bar" class="h-full transition-all duration-300"></div>
                                </div>
                            </div>
                            <p id="strength-text" class="text-sm"></p>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                               placeholder="Confirm your new password">
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Manager Encouragement -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-blue-800 mb-1">💡 Security Tip</h4>
                                <p class="text-sm text-blue-700">Use a password manager to generate and store a strong, unique password for this account.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-pink-500 hover:to-purple-500 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                        Reset Password
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-purple-600 hover:text-purple-500 transition-colors">
                        ← Back to Sign In
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-gray-500 text-sm">
                    After resetting, you'll be redirected to sign in with your new password.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Password strength checker
        const passwordInput = document.getElementById('password');
        const passwordStrength = document.getElementById('password-strength');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            if (password.length > 0) {
                passwordStrength.classList.remove('hidden');
                const strength = checkPasswordStrength(password);
                updateStrengthIndicator(strength);
            } else {
                passwordStrength.classList.add('hidden');
            }
        });

        function checkPasswordStrength(password) {
            let score = 0;
            let feedback = [];

            // Length check
            if (password.length >= 12) {
                score += 2;
            } else if (password.length >= 8) {
                score += 1;
                feedback.push('Add more characters');
            } else {
                feedback.push('Password too short');
            }

            // Character variety checks
            if (/[A-Z]/.test(password)) score += 1;
            if (/[a-z]/.test(password)) score += 1;
            if (/[0-9]/.test(password)) score += 1;
            if (/[^A-Za-z0-9]/.test(password)) score += 1;

            // Additional checks
            if (password.length > 16) score += 1;
            if (!/(.)\1{2,}/.test(password)) score += 1; // No repeated characters
            if (!/(?:abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz|123|234|345|456|567|678|789|012|qwe|wer|ert|rty|tyu|yui|uio|iop|asd|sdf|dfg|fgh|ghj|hjk|jkl|zxc|xcv|cvb|vbn|bnm)/i.test(password)) {
                score += 1; // No sequential characters
            }

            return { score, feedback };
        }

        function updateStrengthIndicator(strength) {
            const { score, feedback } = strength;
            let color, text, width;

            if (score >= 8) {
                color = 'bg-green-500';
                text = 'Very Strong';
                width = '100%';
            } else if (score >= 6) {
                color = 'bg-green-400';
                text = 'Strong';
                width = '75%';
            } else if (score >= 4) {
                color = 'bg-yellow-400';
                text = 'Good';
                width = '50%';
            } else if (score >= 2) {
                color = 'bg-orange-400';
                text = 'Weak';
                width = '25%';
            } else {
                color = 'bg-red-500';
                text = 'Very Weak';
                width = '10%';
            }

            strengthBar.className = `h-full transition-all duration-300 ${color}`;
            strengthBar.style.width = width;
            strengthText.textContent = text;
            strengthText.className = `text-sm ${color.replace('bg-', 'text-')}`;
        }
    </script>
</body>
</html>
