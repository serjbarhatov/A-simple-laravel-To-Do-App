<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Todo App') }}</title>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">The Ultimate To-Do App</h1>
                <p class="text-gray-600">Manage your tasks efficiently</p>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-2xl p-8">
                <div class="flex mb-8 bg-gray-100 rounded-lg p-1">
                    <button id="login-tab" class="flex-1 py-2 px-4 rounded-md font-medium transition-all duration-200 bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-md">
                        Sign In
                    </button>
                    <button id="register-tab" class="flex-1 py-2 px-4 rounded-md font-medium text-gray-600 hover:text-gray-800 transition-all duration-200">
                        Sign Up
                    </button>
                </div>

                <!-- Login Form -->
                <div id="login-form" class="space-y-6">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="login-email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input id="login-email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white/50 backdrop-blur-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="login-password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input id="login-password" type="password" name="password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white/50 backdrop-blur-sm">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-500 transition-colors">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-pink-500 hover:to-purple-500 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                            Sign In
                        </button>
                    </form>
                </div>

                <!-- Register Form -->
                <div id="register-form" class="space-y-6 hidden">
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="register-name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input id="register-name" type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white/50 backdrop-blur-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="register-email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input id="register-email" type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white/50 backdrop-blur-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="register-password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input id="register-password" type="password" name="password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white/50 backdrop-blur-sm">
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

                        <div>
                            <label for="register-password-confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                            <input id="register-password-confirmation" type="password" name="password_confirmation" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-white/50 backdrop-blur-sm">
                        </div>

                        <!-- Password Manager Encouragement -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-blue-800 mb-1">💡 Security Tip</h4>
                                    <p class="text-sm text-blue-700">We recommend using a password manager like <strong>Bitwarden</strong>, <strong>1Password</strong>, or <strong>LastPass</strong> to generate and store strong, unique passwords.</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-pink-500 hover:to-purple-500 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                            Create Account
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-gray-500 text-sm">
                    Get organized and boost your productivity
                </p>
            </div>
        </div>
    </div>

    <script>
        const loginTab = document.getElementById('login-tab');
        const registerTab = document.getElementById('register-tab');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const passwordInput = document.getElementById('register-password');
        const passwordStrength = document.getElementById('password-strength');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');

        loginTab.addEventListener('click', () => {
            loginTab.className = 'flex-1 py-2 px-4 rounded-md font-medium transition-all duration-200 bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-md';
            registerTab.className = 'flex-1 py-2 px-4 rounded-md font-medium text-gray-600 hover:text-gray-800 transition-all duration-200';
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
        });

        registerTab.addEventListener('click', () => {
            registerTab.className = 'flex-1 py-2 px-4 rounded-md font-medium transition-all duration-200 bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-md';
            loginTab.className = 'flex-1 py-2 px-4 rounded-md font-medium text-gray-600 hover:text-gray-800 transition-all duration-200';
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
        });

        // Password strength checker
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

        @if($errors->has('name') || $errors->has('password_confirmation'))
            registerTab.click();
        @endif
    </script>
</body>
</html>
