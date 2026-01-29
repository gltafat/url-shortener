<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShortUrlFactory extends Factory
{
    protected $model = ShortUrl::class;

    public function definition(): array
    {
        return [
            'original_url' => $this->faker->url(),
            'code' => Str::random(6),
            'clicks' => 0,
            'user_id' => User::factory(),
            'last_used_at' => null,
        ];
    }
}
