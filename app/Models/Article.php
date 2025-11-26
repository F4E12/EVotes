<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'related_room_id',
        'title',
        'content',
        'thumbnail_url',
        'published_at',
    ];

    // The published_at column should be treated as a date instance
    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relationships

    /**
     * An Article belongs to a User (the author).
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * An Article may optionally belong to a Room.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'related_room_id');
    }
}