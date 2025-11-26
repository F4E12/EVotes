<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'title',
        'description',
        'unique_token',
        'start_date',
        'end_date',
        'is_revealed',
        'is_closed',
    ];

    // Relationships

    /**
     * A Room belongs to a User (the host).
     */
    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    /**
     * A Room has many Articles.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'related_room_id');
    }

    /**
     * A Room has many Candidates.
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    /**
     * A Room has many Votes.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}