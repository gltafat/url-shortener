<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le lien
        </h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('short-urls.update', $shortUrl) }}">
            @csrf
            @method('PUT')

            <div>
                <label>URL originale</label>
                <input
                    type="text"
                    name="original_url"
                    value="{{ old('original_url', $shortUrl->original_url) }}"
                    class="border p-2 w-full"
                >

                @error('original_url')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button class="bg-blue-500  px-4 py-2 rounded flex items-center gap-2 hover:bg-blue-600">
                    <x-heroicon-o-check class="w-5 h-5"/>
                    Enregistrer
                </button>


                <a href="{{ route('dashboard') }}" class="ml-2 text-gray-600 hover:text-gray-800 flex items-center gap-2">
                    <x-heroicon-o-arrow-left class="w-5 h-5"/>
                    Retour
                </a>

            </div>
        </form>
    </div>
</x-app-layout>
