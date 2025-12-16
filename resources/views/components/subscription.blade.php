@php
    use App\Helpers\ConfigHelper;
@endphp

@php
    $user = auth()->user();
    $hasSubscription = $user && $user->subscribed('default');
    $hasLifetime = $user && $user->lifetime_access;
@endphp

@if (ConfigHelper::getConfigValue('enablestripe') === 'true')
<div class="flex flex-col md:flex-row items-center justify-center bg-white border text-center rounded-lg shadow p-6 mb-4 gap-2">

    {{-- Icono --}}
    <div class="flex justify-center md:justify-start w-full md:w-auto">
        <svg width="124px" height="124px" viewBox="0 -9 58 58" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect x="0.5" y="0.5" width="57" height="39" rx="3.5" fill="white" stroke="#e5b86c"></rect> <path fill-rule="evenodd" clip-rule="evenodd" d="M30.6556 14.3007L27.8667 14.9127V12.6007L30.6556 12V14.3007ZM36.4556 15.5813C35.3667 15.5813 34.6667 16.1027 34.2778 16.4653L34.1333 15.7627H31.6889V28.9773L34.4667 28.3767L34.4778 25.1693C34.8778 25.464 35.4667 25.8833 36.4444 25.8833C38.4333 25.8833 40.2444 24.2513 40.2444 20.6587C40.2333 17.372 38.4 15.5813 36.4556 15.5813ZM35.7889 23.39C35.1333 23.39 34.7444 23.152 34.4778 22.8573L34.4667 18.6527C34.7556 18.324 35.1556 18.0973 35.7889 18.0973C36.8 18.0973 37.5 19.2533 37.5 20.738C37.5 22.2567 36.8111 23.39 35.7889 23.39ZM49 20.772C49 17.8707 47.6222 15.5813 44.9889 15.5813C42.3444 15.5813 40.7444 17.8707 40.7444 20.7493C40.7444 24.1607 42.6333 25.8833 45.3444 25.8833C46.6667 25.8833 47.6667 25.5773 48.4222 25.1467V22.88C47.6667 23.2653 46.8 23.5033 45.7 23.5033C44.6222 23.5033 43.6667 23.118 43.5444 21.7807H48.9778C48.9778 21.7182 48.9818 21.5763 48.9864 21.4128C48.9926 21.1907 49 20.9287 49 20.772ZM43.5111 19.6953C43.5111 18.4147 44.2778 17.882 44.9778 17.882C45.6556 17.882 46.3778 18.4147 46.3778 19.6953H43.5111ZM27.8667 15.774H30.6556V25.6907H27.8667V15.774ZM24.7 15.774L24.8778 16.6127C25.5333 15.3887 26.8333 15.638 27.1889 15.774V18.3807C26.8444 18.256 25.7333 18.0973 25.0778 18.97V25.6907H22.3V15.774H24.7ZM19.3222 13.3147L16.6111 13.904L16.6 22.982C16.6 24.6593 17.8333 25.8947 19.4778 25.8947C20.3889 25.8947 21.0556 25.7247 21.4222 25.5207V23.22C21.0667 23.3673 19.3111 23.8887 19.3111 22.2113V18.188H21.4222V15.774H19.3111L19.3222 13.3147ZM12.7556 18.0407C12.1667 18.0407 11.8111 18.2107 11.8111 18.6527C11.8111 19.1353 12.423 19.3475 13.1822 19.6109C14.4198 20.0403 16.0487 20.6054 16.0556 22.6987C16.0556 24.7273 14.4667 25.8947 12.1556 25.8947C11.2 25.8947 10.1556 25.702 9.12222 25.2487V22.5513C10.0556 23.0727 11.2333 23.458 12.1556 23.458C12.7778 23.458 13.2222 23.288 13.2222 22.7667C13.2222 22.2321 12.5589 21.9878 11.7581 21.6928C10.5385 21.2435 9 20.6768 9 18.7887C9 16.7827 10.5 15.5813 12.7556 15.5813C13.6778 15.5813 14.5889 15.7287 15.5111 16.1027V18.766C14.6667 18.3013 13.6 18.0407 12.7556 18.0407Z" fill="#6772E5"></path> </g></svg>
    </div>
@if ($hasSubscription || $hasLifetime)

    <div class="flex-1 max-w-xl text-center">
        <h3 class="text-gray-800 font-semibold text-base mb-2">
            {{ __('¡Gracias por apoyar el proyecto!') }}
        </h3>

        <p class="text-sm text-gray-600">
            @if ($hasLifetime)
                {{ __('Tu donación nos ayuda a mantener la app activa. Tienes acceso completo de por vida.') }}
            @else
                {{ __('Tu suscripción está activa. Gracias por confiar en nosotros.') }}
            @endif
        </p>
    </div>

@else
    {{-- Contenido --}}
    <div class="flex-1 max-w-xl text-center">
        <h3 class="text-gray-800 font-semibold text-base mb-2">
            {{ __('¿Quieres apoyar el desarrollo y mantenimiento de la app?') }}
        </h3>

        <p class="text-sm text-gray-600 mb-2">
            {{ __('Tienes dos opciones:') }}
        </p>

        <ul class="text-sm text-gray-700 list-disc pl-5 text-left sm:text-center mb-4 px-2">
            <li><strong>{{ __('Suscripción anual (5€)') }}</strong>: {{ __('elimina los anuncios durante un año.') }}</li>
            <li><strong>{{ __('Donativo único (mín. 10€)') }}</strong>: {{ __('acceso completo para siempre mientras la app esté activa.') }}</li>
        </ul>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            {{-- Botón Suscripción --}}
            <form method="POST" action="{{ route('checkout') }}">
                @csrf
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-green-700 w-full sm:w-auto flex items-center justify-center gap-2">
                    <svg width="32px" height="32px" viewBox="0 0 1024 1024" class="inline-block" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M512 64l100.266667 76.8 123.733333-17.066667 46.933333 117.333334 117.333334 46.933333-17.066667 123.733333L960 512l-76.8 100.266667 17.066667 123.733333-117.333334 46.933333-46.933333 117.333334-123.733333-17.066667L512 960l-100.266667-76.8-123.733333 17.066667-46.933333-117.333334-117.333334-46.933333 17.066667-123.733333L64 512l76.8-100.266667-17.066667-123.733333 117.333334-46.933333 46.933333-117.333334 123.733333 17.066667z" fill="#8BC34A"></path><path d="M738.133333 311.466667L448 601.6l-119.466667-119.466667-59.733333 59.733334 179.2 179.2 349.866667-349.866667z" fill="#CCFF90"></path></g></svg>
                    {{ __('Suscribirme por 5€') }}
                </button>
            </form>

            {{-- Botón Donativo --}}
            <form method="POST" action="{{ route('donation') }}">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full sm:w-auto flex items-center justify-center gap-2">
                    <svg width="32px" height="32px" viewBox="0 0 1024 1024" class="inline-block" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M249.6 460.8l108.8 211.2 202.666667-83.2 93.866666-270.933333-315.733333 17.066666z" fill="#E69329"></path><path d="M320 768m-166.4 0a166.4 166.4 0 1 0 332.8 0 166.4 166.4 0 1 0-332.8 0Z" fill="#546E7A"></path><path d="M320 576c-106.666667 0-192 85.333333-192 192s85.333333 192 192 192 192-85.333333 192-192-85.333333-192-192-192z m0 341.333333c-83.2 0-149.333333-66.133333-149.333333-149.333333s66.133333-149.333333 149.333333-149.333333 149.333333 66.133333 149.333333 149.333333-66.133333 149.333333-149.333333 149.333333z" fill="#90A4AE"></path><path d="M298.666667 704h42.666666v170.666667h-42.666666z" fill="#90A4AE"></path><path d="M275.2 768c21.333333 40.533333 68.266667 57.6 108.8 36.266667l352-181.333334c21.333333-10.666667 36.266667-25.6 46.933333-40.533333 36.266667-68.266667 119.466667-228.266667 174.933334-366.933333l-388.266667 185.6-102.4 153.6-145.066667 76.8c-55.466667 27.733333-72.533333 89.6-46.933333 136.533333z" fill="#FFB74D"></path><path d="M644.266667 64L292.266667 198.4c-14.933333 4.266667-32 21.333333-46.933334 36.266667l-119.466666 160c-21.333333 32-25.6 72.533333-10.666667 108.8 8.533333 21.333333 36.266667 72.533333 66.133333 130.133333C215.466667 597.333333 264.533333 576 320 576c8.533333 0 19.2 0 27.733333 2.133333l-44.8-89.6 98.133334-87.466666h170.666666s330.666667-46.933333 388.266667-185.6L644.266667 64z" fill="#FFB74D"></path><path d="M388.266667 768c-27.733333 12.8-59.733333 0-70.4-27.733333-12.8-27.733333 0-59.733333 27.733333-70.4 25.6-12.8 68.266667 85.333333 42.666667 98.133333z" fill="#FFCDD2"></path></g></svg>
                    {{ __('Hacer donativo de 10€ o más') }}
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endif
