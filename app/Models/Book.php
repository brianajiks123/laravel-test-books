<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'title',
        'serial_number',
        'published_at',
        'author_id',
    ];

    // Relations
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
