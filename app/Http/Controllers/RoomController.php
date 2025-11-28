<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::where('host_id', auth()->id())->get();
        return view('pages.dashboard', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.host-a-room');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'candidates' => 'required|array|min:2',
            'candidates.*.name' => 'required|string|max:255',
            'candidates.*.vision' => 'required|string',
            'candidates.*.mission' => 'required|string',
            'candidates.*.photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $room = Room::create([
            'host_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'unique_token' => $this->generateToken(),
        ]);

        foreach ($request->candidates as $candidateData) {
            $photoPath = null;
            if (isset($candidateData['photo_url'])) {
                $photoPath = $candidateData['photo_url']->store('photos', 'public');
            }

            $room->candidates()->create([
                'name' => $candidateData['name'],
                'vision' => $candidateData['vision'],
                'mission' => $candidateData['mission'],
                'photo_url' => $photoPath,
            ]);
        }

        return redirect()->route('rooms.show', $room);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        if ($room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this room.');
        } else {
            $candidates = $room->candidates;
            return view('pages.room.show', compact('room', 'candidates'));
        }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        if ($room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this room.');
        }

        return view('pages.room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        if ($room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this room.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.show', $room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        if ($room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this room.');
        }

        // Hapus foto kandidat sebelum menghapus kandidat
        foreach ($room->candidates as $candidate) {
            if ($candidate->photo) {
                Storage::delete('public/photos/' . $candidate->photo);
            }
        }

        $room->delete();

        return redirect()->route('dashboard');
    }

    /**
     * Close voting for the specified room.
     */
    public function close(Room $room)
    {
        if ($room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this room.');
        }

        $room->update(['end_date' => now()]);
        return redirect()->route('rooms.show', $room);
    }

    /**
     * Generate a unique token.
     */
    private function generateToken()
    {
        do {
            $token = Str::random(6);
        } while (Room::where('unique_token', $token)->exists());

        return $token;
    }
}
//
