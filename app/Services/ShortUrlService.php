<?php

namespace App\Services;

use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class ShortUrlService
{
    public function create(string $originalUrl, int $userId): ShortUrl
    {
        return retry(5, function () use ($originalUrl, $userId) {
            try {
                return ShortUrl::create([
                    'original_url' => $originalUrl,
                    'code' => Str::random(6),
                    'user_id' => $userId,
                ]);
            } catch (QueryException $e) {
                throw $e;
            }
        }, 100);
    }
}
