<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        $shortUrl = ShortUrl::create([
            'original_url' => $request->original_url,
            'code' => substr(md5(uniqid()), 0, 6),
        ]);

        return response()->json($shortUrl);
    }

}
