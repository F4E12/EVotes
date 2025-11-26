<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'photo_url',
        'vision',
        'mission',
    ];

    // Relationships

    /**
     * A Candidate belongs to a Room.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * A Candidate can receive many Votes.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}