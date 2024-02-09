<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Instrument') }}
        </h2>
    </x-slot>

    <div>
        <form method="post" action="{{ route('instrument.update', $instrument->id) }}">
            @csrf
            @method('PUT')
            <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 w-full">
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200">
                                            {{ $instrument->id }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200">
                                            {{ $instrument->name }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ordre
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200">
                                            {{ $instrument->orden }}
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Icon
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200">
                                            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                                                <!-- Profile Photo File Input -->
                                                <input type="file" id="photo" class="hidden"
                                                            wire:model.live="photo"
                                                            x-ref="photo"
                                                            x-on:change="
                                                                    photoName = $refs.photo.files[0].name;
                                                                    const reader = new FileReader();
                                                                    reader.onload = (e) => {
                                                                        photoPreview = e.target.result;
                                                                    };
                                                                    reader.readAsDataURL($refs.photo.files[0]);
                                                            " />
                                
                                                <x-label for="photo" value="{{ __('Photo') }}" />
                                
                                                <!-- Current Profile Photo -->
                                                <div class="mt-2" x-show="! photoPreview">
                                                    <img src="{{ $instrument->icono }}" alt="{{ $instrument->name }}" class="rounded-full h-20 w-20 object-cover">
                                                </div>
                                
                                                <!-- New Profile Photo Preview -->
                                                <div class="mt-2" x-show="photoPreview" style="display: none;">
                                                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                                    </span>
                                                </div>
                                
                                                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                                                    {{ __('Select A New Photo') }}
                                                </x-secondary-button>
                                
                                                @if ( $instrument->icono )
                                                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                                                        {{ __('Remove Photo') }}
                                                    </x-secondary-button>
                                                @endif
                                
                                                <x-input-error for="photo" class="mt-2" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                        </th>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200">
                                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block mt-8">
                    <a href="{{ route('instrument.index') }}" class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded">Back to list</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
