<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortUrlRequest;
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

    public function store(StoreShortUrlRequest $request)
    {
        ShortUrl::create([
            'original_url' => $request->validated()['original_url'],
            'code' => Str::random(6),
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Lien créé avec succès');
    }

    public function edit(ShortUrl $shortUrl)
    {
        $this->authorize('update', $shortUrl);

        return view('shorturls.edit', compact('shortUrl'));
    }

    public function update(StoreShortUrlRequest $request, ShortUrl $shortUrl)
    {
        $this->authorize('update', $shortUrl);

        $shortUrl->update([
            'original_url' => $request->validated()['original_url'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Lien mis à jour');
    }

    public function destroy(ShortUrl $shortUrl)
    {
        $this->authorize('delete', $shortUrl);

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
}
