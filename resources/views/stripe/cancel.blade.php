{{-- resources/views/stripe/cancel.blade.php --}}
<x-app-layout>
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="max-w-xl text-center px-4">
            <svg class="mx-auto mt-4 mb-4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                width="64px" height="64px" viewBox="0 0 128 128" enable-background="new 0 0 128 128" xml:space="preserve"
                fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <g>
                        <g>
                            <path fill="#B0BEC5"
                                d="M64,0C28.656,0,0,28.656,0,64s28.656,64,64,64s64-28.656,64-64S99.344,0,64,0z M64,120 C33.125,120,8,94.875,8,64S33.125,8,64,8s56,25.125,56,56S94.875,120,64,120z">
                            </path>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path fill="#F44336"
                                d="M75.313,64l16.969-16.969c3.125-3.125,3.125-8.195,0-11.313c-3.117-3.125-8.188-3.125-11.313,0L64,52.688 L47.031,35.719c-3.125-3.125-8.195-3.125-11.313,0c-3.125,3.117-3.125,8.188,0,11.313L52.688,64L35.719,80.969 c-3.125,3.125-3.125,8.195,0,11.313c3.117,3.125,8.188,3.125,11.313,0L64,75.313l16.969,16.969c3.125,3.125,8.195,3.125,11.313,0 c3.125-3.117,3.125-8.188,0-11.313L75.313,64z">
                            </path>
                        </g>
                    </g>
                </g>
            </svg>
            <h1 class="text-2xl font-bold text-red-600 mb-4">Pago cancelado</h1>
            <p class="text-gray-600">Parece que has cancelado el proceso. Puedes intentarlo de nuevo cuando quieras.</p>
            <a href="{{ route('dashboard') }}"
                class="mt-6 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Volver al panel</a>
        </div>
    </div>
</x-app-layout>
