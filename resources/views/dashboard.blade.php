<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/shorten') }}" class="flex items-center gap-3">
            @csrf

            <div class="flex-1">
                <input
                    type="url"
                    name="original_url"
                    placeholder="https://example.com"
                    value="{{ old('original_url') }}"
                    class="border p-2 w-full rounded"
                    required
                >

                @error('original_url')
                    <div class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button class="bg-blue-500 px-4 py-2 rounded flex items-center gap-2">
                <x-heroicon-o-plus class="w-5 h-5"/>
                Ajouter
            </button>

        </form>

        <table class="w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">URL</th>
                    <th class="p-2 border">Lien court</th>
                    <th class="p-2 border">Clicks</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($shortUrls as $shortUrl)
                    <tr>
                        <td class="p-2 border">
                            {{ $shortUrl->original_url }}
                        </td>

                        <td class="p-2 border text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a
                                    href="{{ url('/' . $shortUrl->code) }}"
                                    target="_blank"
                                    class="text-blue-600 underline"
                                >
                                    {{ url('/' . $shortUrl->code) }}
                                </a>

                                <button
                                    onclick="copyToClipboard('{{ url('/' . $shortUrl->code) }}')"
                                    class="text-gray-500 hover:text-black flex items-center"
                                    title="Copier le lien"
                                >
                                    <x-heroicon-o-clipboard class="w-5 h-5"/>
                                </button>

                            </div>
                        </td>

                        <td class="p-2 border text-center">
                            {{ $shortUrl->clicks }}
                        </td>

                        <td class="p-2 border">
                            <div class="flex items-center justify-center gap-3">
                                <a
                                    href="{{ route('short-urls.edit', $shortUrl) }}"
                                    class="text-blue-600 hover:text-blue-800 flex items-center"
                                >
                                    <x-heroicon-o-pencil class="w-5 h-5"/>
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('short-urls.destroy', $shortUrl) }}"
                                    onsubmit="return confirm('Supprimer ce lien ?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-600 hover:text-red-800 flex items-center"
                                    >
                                        <x-heroicon-o-trash class="w-5 h-5"/>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            Aucun lien pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $shortUrls->links() }}
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    alert('Lien copié dans le presse-papier');
                })
                .catch(() => {
                    alert('Erreur lors de la copie');
                });
        }
    </script>
</x-app-layout>
