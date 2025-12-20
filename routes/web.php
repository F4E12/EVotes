<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AIController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return back();
})->name('switch.language');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [RoomController::class, 'index'])->name('dashboard');
    Route::get('/host-a-room', [RoomController::class, 'create'])->name('host-a-room');

    Route::get('/join/{share_code}', [VoteController::class, 'joinViaDirectLink'])->name('vote.direct');
    Route::get('/join-a-room', [VoteController::class, 'showJoinForm'])->name('join-a-room');
    Route::post('/join-a-room', [VoteController::class, 'processJoin'])->name('join.process');
    Route::get('/history', [VoteController::class, 'history'])->name('history');

    Route::middleware('room.participant')->group(function () {
        Route::get('/vote/{room_id}', [VoteController::class, 'showVotingBooth'])->name('vote.booth');
        Route::post('/vote/{room_id}', [VoteController::class, 'storeVote'])->name('vote.store');
        Route::get('rooms/{room_id}/results', [VoteController::class, 'showRealCount'])->name('rooms.results');
    });

    Route::post('rooms', action: [RoomController::class, 'store'])->name('rooms.store');
    Route::get('rooms/{room_id}', [RoomController::class, 'show'])->name('rooms.show');
    Route::get('rooms/{room_id}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('rooms/{room_id}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/{room_id}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    Route::post('rooms/{room_id}/close', [RoomController::class, 'close'])->name('rooms.close');

    Route::patch('rooms/{room_id}/toggle-reveal', [RoomController::class, 'toggleReveal'])->name('rooms.toggle-reveal');

    Route::post('rooms/{room_id}/candidates', [CandidateController::class, 'store'])->name('rooms.candidates.store');
    Route::get('candidates/{candidate_id}/edit', [CandidateController::class, 'edit'])->name('candidates.edit');
    Route::put('candidates/{candidate_id}', [CandidateController::class, 'update'])->name('candidates.update');
    Route::delete('candidates/{candidate_id}', [CandidateController::class, 'destroy'])->name('candidates.destroy');

    Route::resource('articles', ArticleController::class);
    Route::post('/ai/enhance', [AIController::class, 'enhanceText'])->name('ai.enhance');
});

require __DIR__ . '/auth.php';
