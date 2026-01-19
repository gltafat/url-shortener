<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return auth()->check()
        ? redirect('/dashboard')
        : view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [ShortUrlController::class, 'index'])
        ->name('dashboard');

    Route::post('/shorten', [ShortUrlController::class, 'store']);

    Route::get('/shorten/{shortUrl}/edit', [ShortUrlController::class, 'edit'])
        ->name('short-urls.edit');

    Route::put('/shorten/{shortUrl}', [ShortUrlController::class, 'update'])
        ->name('short-urls.update');

    Route::delete('/shorten/{shortUrl}', [ShortUrlController::class, 'destroy'])
        ->name('short-urls.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

Route::get('/{code}', [ShortUrlController::class, 'redirect']);