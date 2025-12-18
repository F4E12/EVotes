<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Room;
use App\Models\Candidate;
use App\Models\RoomParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function showJoinForm()
    {
        return view('pages.join-a-room');
    }

    public function processJoin(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);


        $room = Room::where('unique_token', $request->token)->first();

        if (!$room) {
            return back()->with('error', __('Invalid token or Room not found.'));
        }

        if (now() > $room->end_date) {
            return back()->with('error', __('Voting session for this room has ended.'));
        }

        RoomParticipant::firstOrCreate([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
        ]);

        return redirect()->route('vote.booth', $room->room_id);
    }

    public function showVotingBooth($room_id)
    {
        $room = Room::where('room_id', $room_id)->firstOrFail();

        if (now() > $room->end_date) {
            return redirect()->route('rooms.results', $room->room_id)->with('error', __('The voting period has ended.'));
        }

        $hasVoted = Vote::where('voter_id', Auth::id())
            ->where('room_id', $room->id)
            ->exists();

        if ($hasVoted) {
            return redirect()->route('rooms.results', $room->room_id)->with('error', __('You have already voted in this room.'));
        }

        $candidates = Candidate::where('room_id', $room->id)->get();

        return view('pages.vote.booth', compact('room', 'candidates'));
    }

    public function storeVote(Request $request, $room_id)
    {
        $room = Room::where('room_id', $room_id)->firstOrFail();

        if (now() > $room->end_date) {
            return back()->with('error', __('Voting period has ended! Your vote was not saved.'));
        }

        $request->validate([
            'candidate_id' => 'required|exists:candidates,candidate_id',
        ]);

        $candidate = Candidate::where('candidate_id', $request->candidate_id)->firstOrFail();

        $existingVote = Vote::where('voter_id', Auth::id())
            ->where('room_id', $room->id)
            ->first();

        if ($existingVote) {
            return back()->with('error', __('You have already voted!'));
        }

        Vote::create([
            'voter_id' => Auth::id(),
            'room_id' => $room->id,
            'candidate_id' => $candidate->id,
            'voted_at' => now(),
        ]);

        return redirect()->route('history')->with('success', __('Vote recorded successfully!'));
    }

    public function history()
    {
        $votes = Vote::with(['room', 'candidate'])
            ->where('voter_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.history', compact('votes'));
    }

    public function showRealCount($room_id)
    {
        $room = Room::where('room_id', $room_id)->firstOrFail();

        $candidates = Candidate::where('room_id', $room->id)
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->get();

        $showResults = $room->is_revealed || (now() > $room->end_date);

        return view('pages.room.result', compact('room', 'candidates', 'showResults'));
    }

    public function joinViaDirectLink($share_code)
    {
        $room = Room::where('share_code', $share_code)->firstOrFail();

        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('intended_share_code', $share_code)
                ->with('info', __('Please login to join the voting room.'));
        }

        if (now() > $room->end_date) {
            return redirect()->route('rooms.results', $room->room_id)
                ->with('error', __('Voting session for this room has ended.'));
        }

        RoomParticipant::firstOrCreate([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
        ]);

        return redirect()->route('vote.booth', $room->room_id);
    }
}
