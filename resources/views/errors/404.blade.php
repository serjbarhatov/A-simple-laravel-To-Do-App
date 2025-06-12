<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 min-h-screen flex items-center justify-center">
    <div class="bg-white/90 p-10 rounded-2xl shadow-2xl flex flex-col items-center max-w-lg">
        <div class="text-7xl mb-4">🚧</div>
        <h1 class="text-4xl font-extrabold text-purple-700 mb-2">404</h1>
        <p class="text-lg text-gray-700 mb-6">Oops! The page you're looking for doesn't exist.<br>It might have been moved or deleted.</p>
        <a href="{{ route('todos.index') }}" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-pink-500 hover:to-purple-500 text-white font-bold py-2 px-6 rounded-lg shadow transition-all duration-200">Go Home</a>
        <p class="mt-6 text-sm text-gray-500">If you think this is a mistake, please contact support.</p>
    </div>
</body>
</html> 