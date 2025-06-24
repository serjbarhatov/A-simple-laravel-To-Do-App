<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Todo App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100">
        <div class="min-h-screen flex flex-col">
            <nav class="sticky top-0 z-10 bg-white/80 backdrop-blur border-b border-gray-200 shadow-md">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <div class="flex items-center">
                            <a href="{{ route('todos.index') }}" class="text-2xl font-extrabold text-purple-700 tracking-tight drop-shadow">
                                <span class="inline-block align-middle">📝</span> Todo App
                            </a>
                        </div>
                        <div class="flex items-center space-x-4">
                            @auth
                                <span class="text-gray-700">Welcome, {{ auth()->user()->name }}!</span>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-600 hover:text-gray-800 transition">
                                        Logout
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 transition">Login</a>
                                <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-800 transition">Register</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <main class="flex-1 py-12">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
            @yield('footer')
        </div>
    </body>
</html>
