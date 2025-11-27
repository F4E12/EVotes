<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_url')) {
            $photoPath = $request->file('photo_url')->store('photos', 'public');
        }

        $room->candidates()->create([
            'name' => $request->name,
            'vision' => $request->vision,
            'mission' => $request->mission,
            'photo_url' => $photoPath,
        ]);

        return redirect()->route('rooms.show', $room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
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

        return redirect()->route('rooms.show', $candidate->room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        if ($candidate->room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this candidate.');
        }

        if ($candidate->photo_url) {
            Storage::disk('public')->delete($candidate->photo_url);
        }

        $candidate->delete();

        return redirect()->route('rooms.show', $candidate->room);
    }
}
