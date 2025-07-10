{{-- resources/views/stripe/success.blade.php --}}
<x-app-layout>
    <div class="max-w-xl mx-auto mt-20 text-center">
        <svg class="mx-auto mb-6" width="64" height="64" fill="none" stroke="green" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <h1 class="text-2xl font-bold text-green-700 mb-4">¡Gracias por tu apoyo!</h1>
        <p class="text-gray-600">Tu suscripción se ha procesado correctamente. <br/>Has apoyado el desarrollo de esta app 🙌
        <br/> Ya no verás mas anuncios.</p>
        <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Volver al panel</a>
    </div>
</x-app-layout>
