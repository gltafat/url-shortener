<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    public function it_creates_a_short_url()
    {
        $response = $this->post('/shorten', [
            'original_url' => 'https://example.com',
        ]);

        $response->assertStatus(302); 
        $this->assertDatabaseCount('short_urls', 1);
    }

    public function it_redirects_to_original_url()
    {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com',
            'code' => 'abc123',
        ]);

        $response = $this->get('/abc123');

        $response->assertRedirect('https://example.com');
    }

   
    public function it_increments_clicks_on_redirect()
    {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://example.com',
            'code' => 'click01',
            'clicks' => 0,
        ]);

        $this->get('/click01');

        $this->assertEquals(1, $shortUrl->fresh()->clicks);
    }

    public function it_rejects_invalid_url()
    {
        $response = $this->post('/shorten', [
            'original_url' => 'not-a-url',
        ]);

        $response->assertSessionHasErrors('original_url');
    }
}
