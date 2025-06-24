<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('todos.index');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('todos.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('todos', TodoController::class);
    Route::post('todos/{todo}/toggle-complete', [TodoController::class, 'toggleComplete'])->name('todos.toggle-complete');
});

Route::get('/test500', function () {
    abort(500);
});

require __DIR__.'/auth.php';
