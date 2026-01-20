<x-app-layout>
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center space-y-4">
            <h1 class="text-2xl font-bold text-gray-800">
                Lien invalide
            </h1>

            <p class="text-gray-600">
                Ce lien n’est plus valable ou a expiré.
            </p>

            <a href="{{ url('/') }}" class="text-blue-600 underline">
                Retour à l’accueil
            </a>
        </div>
    </div>
</x-app-layout>
