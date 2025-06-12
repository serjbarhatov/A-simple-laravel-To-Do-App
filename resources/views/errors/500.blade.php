<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Server Error</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gradient-to-br from-red-100 via-yellow-100 to-pink-100 min-h-screen flex items-center justify-center">
    <div class="bg-white/90 p-10 rounded-2xl shadow-2xl flex flex-col items-center max-w-lg">
        <div class="text-7xl mb-4">💥</div>
        <h1 class="text-4xl font-extrabold text-red-600 mb-2">500</h1>
        <p class="text-lg text-gray-700 mb-6">Something went wrong on our end.<br>We're working to fix it!</p>
        <a href="{{ route('todos.index') }}" class="bg-gradient-to-r from-red-500 to-yellow-500 hover:from-yellow-500 hover:to-red-500 text-white font-bold py-2 px-6 rounded-lg shadow transition-all duration-200">Go Home</a>
        <p class="mt-6 text-sm text-gray-500">Try refreshing the page or come back later.</p>
    </div>
</body>
</html>
 