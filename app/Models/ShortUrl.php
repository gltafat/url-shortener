<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ShortUrl extends Model
{
    protected $fillable = [
        'original_url',
        'code',
        'clicks',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
