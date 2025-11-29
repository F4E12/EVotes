<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/history', function () {
    return view('pages.history');
})->middleware(['auth', 'verified'])->name('history');

Route::get('/host-a-room', function () {
    return view('pages.host-a-room');
})->middleware(['auth', 'verified'])->name('host-a-room');

Route::get('/join-a-room', function () {
    return view('pages.join-a-room');
})->middleware(['auth', 'verified'])->name('join-a-room');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('articles', ArticleController::class);
});

require __DIR__ . '/auth.php';
