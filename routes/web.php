<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/dashboard', [RoomController::class, 'index'])->name('dashboard');
    Route::get('/host-a-room', [RoomController::class, 'create'])->name('host-a-room');
    Route::get('/join-a-room', function () {
        return view('pages.join-a-room');
    })->name('join-a-room');
    Route::get('/history', function () {
        return view('pages.history');
    })->name('history');

    ;
    Route::post('rooms', action: [RoomController::class, 'store'])->name('rooms.store');
    Route::get('rooms/{room_id}', [RoomController::class, 'show'])->name('rooms.show');
    Route::get('rooms/{room_id}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('rooms/{room_id}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/{room_id}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    Route::post('rooms/{room_id}/close', [RoomController::class, 'close'])->name('rooms.close');
    Route::post('rooms/{room_id}/candidates', [CandidateController::class, 'store'])->name('rooms.candidates.store');
    Route::put('candidates/{candidate}', [CandidateController::class, 'update'])->name('candidates.update');
    Route::delete('candidates/{candidate}', [CandidateController::class, 'destroy'])->name('candidates.destroy');



});

require __DIR__ . '/auth.php';
