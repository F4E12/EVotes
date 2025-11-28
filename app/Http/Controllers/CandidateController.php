<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class CandidateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $room_id)
    {
        $room = Room::where('room_id', $room_id)->firstOrFail();

        if (!$room) {
            return redirect()->route('dashboard')->with('error', 'Room not found.');
        }

        if ($room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this room.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        CandidateController::createCandidate($request, $room, $request->file('photo_url'));

        return redirect()->route('rooms.show', $room->room_id);
    }

    public static function createCandidate(Request $request, Room $room, $photoFile = null)
    {
        $photoPath = null;
        if ($photoFile) {
            $photoPath = $photoFile->store('photos', 'public');
        }

        $room->candidates()->create([
            'candidate_id' => CandidateController::generateCandidateID(),
            'name' => $request->name,
            'vision' => $request->vision,
            'mission' => $request->mission,
            'photo_url' => $photoPath,
        ]);
    }
    private static function generateCandidateID()
    {
        do {
            $candidateID = 'CN_' . Str::upper(Str::random(10));
        } while (Candidate::where('candidate_id', $candidateID)->exists());

        return $candidateID;
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $candidate_id)
    {
        $candidate = Candidate::where('candidate_id', $candidate_id)->firstOrFail();

        if (!$candidate) {
            return redirect()->route('dashboard')->with('error', 'Candidate not found.');
        }

        if ($candidate->room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this candidate.');
        }

        return view('pages.candidate.edit', compact('candidate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $candidate_id)
    {
        $candidate = Candidate::where('candidate_id', $candidate_id)->firstOrFail();

        if (!$candidate) {
            return redirect()->route('dashboard')->with('error', 'Candidate not found.');
        }

        if ($candidate->room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this candidate.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $photoPath = $candidate->photo_url;
        if ($request->hasFile('photo_url')) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo_url')->store('photos', 'public');
        }

        $candidate->update([
            'name' => $request->name,
            'vision' => $request->vision,
            'mission' => $request->mission,
            'photo_url' => $photoPath,
        ]);

        return redirect()->route('rooms.show', $candidate->room->room_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $candidate_id)
    {
        $candidate = Candidate::where('candidate_id', $candidate_id)->firstOrFail();

        if (!$candidate) {
            return redirect()->route('dashboard')->with('error', 'Candidate not found.');
        }
        if ($candidate->room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this candidate.');
        }


        if ($candidate->room->candidates()->count() <= 2) {
            return redirect()->route('rooms.show', $candidate->room->room_id)->with('error', 'A room must have at least two candidates.');
        }

        if ($candidate->photo_url) {
            Storage::disk('public')->delete($candidate->photo_url);
        }

        $candidate->delete();

        return redirect()->route('rooms.show', $candidate->room->room_id);
    }


}
