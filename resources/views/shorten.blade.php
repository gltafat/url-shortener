<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
</head>
<body>
    <h1>URL Shortener</h1>

    <form method="POST" action="/shorten">
        @csrf

        <input
            type="url"
            name="original_url"
            placeholder="https://example.com"
            value="{{ old('original_url') }}"
            required
        >
        <button type="submit">Shorten</button>

        @error('original_url')
            <div style="color:red; margin-top:8px;">
                {{ $message }}
            </div>
        @enderror
    </form>

    @if(session('short'))
        <hr>
        <p>
            Short URL :
            <a href="{{ session('short') }}">{{ session('short') }}</a>
        </p>
    @endif

    @if(session('error'))
        <hr>
        <p style="color:red;">
            {{ session('error') }}
        </p>
    @endif
</body>
</html>
