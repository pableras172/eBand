<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />
        @if ($errors->has('g-recaptcha-response'))
            <span class="feedbak-error">
                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
            </span>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('auth.nombreyapellidos') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
            </div>

            <div class="mt-2">
                <x-label for="email" value="{{ __('auth.email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
            </div>

<div x-data="{ esPadre: false }" class="col-span-6 sm:col-span-4 mt-4 mb-4">
    <label for="es_padre" class="flex items-center">
        <input id="es_padre" type="checkbox" name="es_padre" value="1"
               x-model="esPadre" class="rounded">
        <span class="ml-2 text-sm text-gray-600">{{ __('Soy padre') }}</span>
    </label>

    <div class="col-span-6 sm:col-span-4 mt-2" x-show="!esPadre">
        <x-label for="instrument_id" value="{{ __('auth.instrument') }}" />
        <select id="instrument_id" name="instrument_id" class="mt-1 block w-full">
            <option value="">{{ __('Selecciona Instrument') }}</option>
            @foreach ($instruments as $instrument)
                <option value="{{ $instrument['id'] }}">{{ $instrument['name'] }}</option>
            @endforeach
        </select>
        <x-input-error for="instrument_id" class="mt-2" />
    </div>
</div>


            <div class="mt-2">
                <x-label for="telefono" value="{{ __('auth.telefono') }}" />
                <x-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')"
                    required autofocus autocomplete="telefono" />
            </div>

            <div class="mt-2">
                <x-label for="password" value="{{ __('auth.contrase') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-2">
                <x-label for="password_confirmation" value="{{ __('auth.repite') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('auth.terminos', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('auth.terminosservicio') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('auth.politicaprivacidad') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-center mt-4">
                {!! NoCaptcha::display() !!}
            </div>
            <div class="flex items-center justify-center mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('auth.yaregistrado') }}
                </a>
                <x-button class="ms-4">
                    {{ __('auth.registrar') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
{!! NoCaptcha::renderJs() !!}
