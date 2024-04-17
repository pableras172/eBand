<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Informació del perfil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Actualice la información del perfil y la dirección de correo electrónico de su cuenta.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
                    x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Foto') }}" />


                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>
                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">{{ __('Tamano maximo 1Mb') }}</p>
                
                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Seleccione una nueva foto') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Borrar foto') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nom') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required
                autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required
                autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                    !$this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 dark:text-white">
                    {{ __('Your email address is unverified.') }}

                    <button type="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        wire:click.prevent="sendEmailVerification">
                        {{ __('Haga clic aquí para volver a enviar el correo electrónico de verificación.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                    </p>
                @endif
            @endif
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="instrument" value="{{ __('Instrument') }}" />
            <select id="instrument" name="instrument" wire:model="state.instrument_id" class="mt-1 block w-full"
                required>
                <option value="">{{ __('Selecciona Instrument') }}</option>

                @foreach ($state['instruments'] as $instrument)
                    <option value="{{ $instrument['id'] }}">{{ $instrument['name'] }}</option>
                @endforeach
            </select>
            <x-input-error for="instrument_id" class="mt-2" />
        </div>

        <!-- Telefono -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="telefono" value="{{ __('Telefon') }}" />
            <x-input id="telefono" type="text" class="mt-1 block w-full" wire:model="state.telefono" />
            <x-input-error for="telefono" class="mt-2" />
        </div>

        <!-- Porcentaje -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="porcentaje" value="{{ __('Percentaje') }}" />
            @if (Auth::user()->roles()->where('title', 'Admin')->exists())
                <x-input id="porcentaje" type="number" class="mt-1 block w-full" wire:model="state.porcentaje" />
            @else
                <input id="porcentaje" type="number" class="mt-1 block w-full" value="{{ $state['porcentaje'] }}" readonly>
            @endif
            <x-input-error for="porcentaje" class="mt-2" />
        </div>
        @if (Auth::user()->roles()->where('title', 'Admin')->exists())
        <!-- Forastero -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="forastero" value="{{ __('Foraster') }}" />
            <x-input id="forastero" type="checkbox" class="mt-1 block" wire:model="state.forastero" />
            <x-input-error for="forastero" class="mt-2" />
        </div>

        <!-- Observaciones -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="observaciones" value="{{ __('Observacions') }}" />
            <textarea id="observaciones" class="mt-1 block w-full" wire:model="state.observaciones"></textarea>
            <x-input-error for="observaciones" class="mt-2" />
        </div>

        <!-- Fecha Alta -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="fechaAlta" value="{{ __('Data Alta') }}" />
            <x-input id="fechaAlta" type="date" class="mt-1 block w-full" wire:model="state.fechaAlta" />
            <x-input-error for="fechaAlta" class="mt-2" />
        </div>

       
            <!-- Activo -->
            <div class="col-span-6 sm:col-span-4">

                <x-label for="activo" value="{{ __('Actiu') }}" />
                <x-input id="activo" type="checkbox" class="mt-1 block" wire:model="state.activo" />
                <x-input-error for="activo" class="mt-2" />

            </div>
        @endif

    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Guardat.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-form-section>
