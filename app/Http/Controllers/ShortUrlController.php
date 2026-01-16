<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;



class ShortUrlController extends Controller
{
    public function index()
    {
        return view('shorten');
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        $shortUrl = ShortUrl::create([
            'original_url' => $request->original_url,
            'code' => substr(md5(uniqid()), 0, 6),
        ]);

        return redirect()->back()->with(
                'short',
                url('/' . $shortUrl->code)
        );

    }

    public function redirect($code)
    {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();
        $shortUrl->increment('clicks');

        return redirect($shortUrl->original_url);
    }

}
