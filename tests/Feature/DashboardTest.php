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

        ShortUrl::factory()->create([
            'original_url' => 'https://laravel.com',
            'user_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response->assertOk();
        $response->assertSee('https://laravel.com');
    }

    public function test_user_can_delete_a_link()
    {
        $user = User::factory()->create();

        $shortUrl = ShortUrl::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete("/shorten/{$shortUrl->id}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('short_urls', [
            'id' => $shortUrl->id,
        ]);
    }

    public function test_dashboard_is_paginated()
    {
        $user = User::factory()->create();

        ShortUrl::factory()
            ->count(15)
            ->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Next');
    }

}
