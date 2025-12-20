<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Room;
use App\Models\RoomParticipant;
use Illuminate\Support\Facades\Auth;

class EnsureRoomParticipant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $roomId = $request->route('room_id');

        $room = Room::where('room_id', $roomId)->first();

        if (!$room) {
            return redirect()->route('dashboard')->with('error', 'Room not found.');
        }

        if ($room->user_id === Auth::id()) {
            return $next($request);
        }

        $isParticipant = RoomParticipant::where('user_id', Auth::id())
            ->where('room_id', $room->id)
            ->exists();

        if (!$isParticipant) {
            return redirect()->route('dashboard')->with('error', 'You must join the room first using the room token.');
        }

        return $next($request);
    }
}
