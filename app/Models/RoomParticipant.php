<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomParticipant extends Model
{
    use HasFactory;

    protected $table = 'room_participants';

    protected $fillable = [
        'user_id',
        'room_id',
        'role',
        'is_banned',
    ];

    /**
     * Relationship: A participant belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A participant belongs to a Room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
