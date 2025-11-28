<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\String_;

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
            'room_id' => $this->generateRoomID(),
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

        return redirect()->route('rooms.show', $room->room_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $room_id)
    {
        $room = Room::where('room_id', $room_id)->firstOrFail();

        if (!$room) {
            return redirect()->route('dashboard')->with('error', 'Room not found.');
        }
        if ($room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this room.');
        }

        $candidates = $room->candidates;
        $status = $this->getRoomStatus($room);
        return view('pages.room.show', compact('room', 'candidates', 'status'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $room_id)
    {
        $room = Room::where('room_id', $room_id)->firstOrFail();

        if (!$room) {
            return redirect()->route('dashboard')->with('error', 'Room not found.');
        }

        if ($room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this room.');
        }

        return view('pages.room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $room_id)
    {
        $room = Room::where('room_id', $room_id)->firstOrFail();

        if (!$room) {
            return redirect()->route('dashboard')->with('error', 'Room not found.');
        }

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

        return redirect()->route('rooms.show', $room->room_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $room_id)
    {
        $room = Room::where('room_id', $room_id)->firstOrFail();

        if (!$room) {
            return redirect()->route('dashboard')->with('error', 'Room not found.');
        }
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
    public function close(string $room_id)
    {
        $room = Room::where('room_id', $room_id)->firstOrFail();

        if (!$room) {
            return redirect()->route('dashboard')->with('error', 'Room not found.');
        }

        if ($room->host_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this room.');
        }

        $room->update(['end_date' => now()]);

        if (now()->lt($room->start_date)) {
            $room->update(['start_date' => now()]);
        }

        return redirect()->route('rooms.show', $room->room_id);
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

    public function getRoomStatus(Room $room)
    {
        $now = now();

        if ($now->lt($room->start_date)) {
            return 'upcoming';
        } elseif ($now->between($room->start_date, $room->end_date)) {
            return 'ongoing';
        } else {
            return 'ended';
        }
    }

    public function generateRoomID()
    {
        do {
            $roomID = 'RM_' . (Str::random(10));
        } while (Room::where('room_id', $roomID)->exists());

        return $roomID;
    }
}

