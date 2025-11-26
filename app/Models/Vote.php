<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'candidate_id',
        'voter_id',
        'voted_at',
    ];

    protected $casts = [
        'voted_at' => 'datetime',
    ];

    // Relationships

    /**
     * A Vote belongs to a Room.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * A Vote belongs to a Candidate.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * A Vote belongs to a User (the voter).
     */
    public function voter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'voter_id');
    }
}