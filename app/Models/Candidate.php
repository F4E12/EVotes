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
        'candidate_id',
        'room_id',
        'name',
        'photo_url',
        'vision',
        'mission',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}