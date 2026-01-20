<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Illuminate\Support\Str;



class ShortUrlController extends Controller
{
    public function index()
    {
        $shortUrls = auth()->user()
            ->shortUrls()
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('shortUrls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => ['required', 'url'],
        ]);

        ShortUrl::create([
            'original_url' => $request->original_url,
            'code' => Str::random(6),
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Lien créé avec succès');
    }

    public function edit(ShortUrl $shortUrl)
    {
        $this->authorizeOwner($shortUrl);

        return view('shorturls.edit', compact('shortUrl'));
    }

    public function update(Request $request, ShortUrl $shortUrl)
    {
        $this->authorizeOwner($shortUrl);

        $request->validate([
            'original_url' => ['required', 'url'],
        ]);

        $shortUrl->update([
            'original_url' => $request->original_url,
        ]);

        return redirect()->route('dashboard')->with('success', 'Lien mis à jour');
    }

    public function destroy(ShortUrl $shortUrl)
    {
        $this->authorizeOwner($shortUrl);

        $shortUrl->delete();

        return redirect()->back()->with('success', 'Lien supprimé');
    }

    public function redirect(string $code)
    {
        $shortUrl = ShortUrl::where('code', $code)->first();

        if (! $shortUrl) {
            return response()
                ->view('short-url-expired', [], 410);
        }

        $shortUrl->increment('clicks');
        $shortUrl->update([
        'last_used_at' => now(),
        ]);

        return redirect($shortUrl->original_url);
    }

    private function authorizeOwner(ShortUrl $shortUrl): void
    {
        if ($shortUrl->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
