<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_short_url()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/shorten', [
            'original_url' => 'https://example.com',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com',
            'user_id' => $user->id,
        ]);
    }

    public function test_it_redirects_to_original_url()
    {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com',
            'code' => 'abc123',
            'user_id' => User::factory()->create()->id,
        ]);

        $response = $this->get('/abc123');

        $response->assertRedirect('https://example.com');
    }

    public function test_it_increments_clicks_on_redirect()
    {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com',
            'code' => 'click01',
            'clicks' => 0,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->get('/click01');

        $this->assertEquals(1, $shortUrl->fresh()->clicks);
    }

    public function test_it_rejects_invalid_url()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/shorten', [
            'original_url' => 'not-a-url',
        ]);

        $response->assertSessionHasErrors('original_url');
    }
}
