<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [RoomController::class, 'index'])->name('dashboard');

    Route::get('/host-a-room', [RoomController::class, 'create'])->name('host-a-room');

    Route::get('/join-a-room', function () {
        return view('pages.join-a-room');
    })->name('join-a-room');

    Route::get('/history', function () {
        return view('pages.history');
    })->name('history');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('rooms', RoomController::class)->except(['index', 'create']);
    Route::post('rooms/{room}/close', [RoomController::class, 'close'])->name('rooms.close');

    Route::post('rooms/{room}/candidates', [CandidateController::class, 'store'])->name('rooms.candidates.store');
    Route::put('candidates/{candidate}', [CandidateController::class, 'update'])->name('candidates.update');
    Route::delete('candidates/{candidate}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
});

require __DIR__ . '/auth.php';
