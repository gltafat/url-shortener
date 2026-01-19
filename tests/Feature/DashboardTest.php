<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_user_links()
    {
        $user = User::factory()->create();

        ShortUrl::create([
            'original_url' => 'https://laravel.com',
            'code' => 'laravel',
            'clicks' => 0,
            'user_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('https://laravel.com');
    }

    public function test_user_can_delete_a_link()
    {
        $user = User::factory()->create();

        $shortUrl = ShortUrl::create([
            'original_url' => 'https://delete-me.com',
            'code' => 'delete',
            'clicks' => 0,
            'user_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete("/shorten/{$shortUrl->id}");

        $response->assertStatus(302);

        $this->assertDatabaseMissing('short_urls', [
            'id' => $shortUrl->id,
        ]);
    }

    public function test_dashboard_is_paginated()
    {
        $user = User::factory()->create();

        for ($i = 1; $i <= 15; $i++) {
            ShortUrl::create([
                'original_url' => "https://example{$i}.com",
                'code' => "code{$i}",
                'clicks' => 0,
                'user_id' => $user->id,
            ]);
        }

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200);

        $response->assertSee('Next');
    }

}
