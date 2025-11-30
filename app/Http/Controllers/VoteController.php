<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Room;
use App\Models\Candidate;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function showRealCount($room_id)
    {
            $room = Room::where('room_id', $room_id)->firstOrFail();

    $adminRevealed = $room->is_revealed;

    $timeIsUp = $room->end_date && now()->greaterThan($room->end_date);

    $candidates = Candidate::where('room_id', $room->id)
        ->withCount('votes')
        ->orderByDesc('votes_count')
        ->get();

    $showResults = $room->is_revealed || (now() > $room->end_date);
    return view('pages.room.result', compact('room', 'candidates', 'showResults'));
    }
}
