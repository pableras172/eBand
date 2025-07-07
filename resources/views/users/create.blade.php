<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (!isset($user))
                {{ __('Nou Music') }}
            @else
                {{ __('Editar músic') }}
            @endif
        </h2>
    </x-slot>

    <div>
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">

                <form method="post"
                    action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}">
                    @csrf
                    @if (isset($user))
                        @method('PUT')
                    @endif
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="name"
                                class="block font-medium text-sm text-gray-700">{{ __('Nom') }}</label>
                            <input type="text" name="name" id="name"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                value="{{ isset($user) ? $user->name : old('name') }}" />
                            @error('name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="email"
                                class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                value="{{ isset($user) ? $user->email : old('email') }}" />
                            @error('email')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="password"
                                class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
                            <input type="password" name="password" id="password"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                value="{{ isset($user) ? '' : Hash::make('Banda2024') }}" />
                            <span
                                class="text-sm text-gray-500">{{ __('Valor predeterminado: Banda2024 (Puedes cambiarlo)') }}</span>
                            @error('password')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="instrument"
                                class="block font-medium text-sm text-gray-700">{{ __('Instrument') }}</label>
                            <select name="instrument_id" id="instrument"
                                class="form-select rounded-md shadow-sm mt-1 block w-full">
                                <option value="">{{ __('Selecciona un instrument') }}</option>
                                @foreach ($instruments as $instrument)
                                    <option value="{{ $instrument->id }}"
                                        {{ isset($user) && $user->instrument_id == $instrument->id ? 'selected' : '' }}>
                                        {{ $instrument->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('instrument_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>




                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="telefono"
                                class="block font-medium text-sm text-gray-700">{{ __('Telefon') }}</label>
                            <input type="text" name="telefono" id="telefono"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                value="{{ isset($user) ? $user->telefono : old('telefono') }}" />
                            @error('telefono')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="porcentaje"
                                class="block font-medium text-sm text-gray-700">{{ __('Percentaje') }}</label>
                            <input type="number" name="porcentaje" id="porcentaje"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                value="{{ isset($user) ? $user->porcentaje : old('porcentaje') }}" />
                            @error('porcentaje')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="forastero"
                                class="block font-medium text-sm text-gray-700">{{ __('Foraster') }}</label>
                            <input type="checkbox" name="forastero" id="forastero"
                                class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out"
                                {{ (isset($user) && $user->forastero) || old('forastero') ? 'checked' : '' }}>
                            @error('forastero')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="activo"
                                class="block font-medium text-sm text-gray-700">{{ __('Actiu') }}</label>
                            <input type="checkbox" name="activo" id="activo"
                                class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out"
                                {{ (isset($user) && $user->activo) || old('activo') ? 'checked' : '' }}>
                            @error('activo')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="fechaAlta"
                                class="block font-medium text-sm text-gray-700">{{ __('Data Alta') }}</label>
                            <input type="date" name="fechaAlta" id="fechaAlta"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                value="{{ isset($user) ? $user->fechaAlta : old('fechaAlta') }}" />
                            @error('fechaAlta')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="es_padre" class="block font-medium text-sm text-gray-700">
                                {{ __('És pare/mare?') }}
                            </label>
                            <input type="checkbox" id="es_padre"
                                class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out"
                                onchange="toggleHijos()" />

                            <div id="selector-hijos" class="mt-4 hidden">
                                <label for="hijos"
                                    class="block font-medium text-sm text-gray-700">{{ __('Selecciona fills') }}</label>
                                <select name="hijos[]" id="hijos" multiple
                                    class="form-multiselect block w-full mt-1 rounded-md shadow-sm">
                                    @foreach ($todosLosUsuarios as $posibleHijo)
                                        @if (!isset($user) || $posibleHijo->id !== $user->id)
                                            <option value="{{ $posibleHijo->id }}"
                                                {{ isset($user) && $user->hijos->contains($posibleHijo->id) ? 'selected' : '' }}>
                                                {{ $posibleHijo->name }} ({{ $posibleHijo->email }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <script>
                            function toggleHijos() {
                                const checkbox = document.getElementById('es_padre');
                                const hijosDiv = document.getElementById('selector-hijos');
                                hijosDiv.classList.toggle('hidden', !checkbox.checked);
                            }

                            // Mostrar al cargar si ya tiene hijos
                            document.addEventListener('DOMContentLoaded', function() {
                                @if (isset($user) && $user->hijos->count())
                                    document.getElementById('es_padre').checked = true;
                                    toggleHijos();
                                @endif
                            });
                        </script>

                        <input type="hidden" name="es_padre" id="es_padre_hidden" value="0">

                        <script>
                            const checkbox = document.getElementById('es_padre');
                            checkbox.addEventListener('change', function() {
                                document.getElementById('es_padre_hidden').value = this.checked ? 1 : 0;
                            });

                            // Para cuando ya está marcado al cargar
                            document.addEventListener('DOMContentLoaded', function() {
                                document.getElementById('es_padre_hidden').value = checkbox.checked ? 1 : 0;
                            });
                        </script>


                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="roles"
                                class="block font-medium text-sm text-gray-700">{{ __('Roles') }}</label>
                            <select name="roles[]" id="roles"
                                class="form-multiselect block rounded-md shadow-sm mt-1 block w-full"
                                multiple="multiple">
                                @foreach ($roles as $id => $role)
                                    <option
                                        value="{{ $id }}"{{ isset($user) && $user->roles->contains($id) ? ' selected' : '' }}>
                                        {{ $role }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="observaciones"
                                class="block font-medium text-sm text-gray-700">{{ __('Observacions') }}</label>
                            <textarea name="observaciones" id="observaciones" class="form-textarea rounded-md shadow-sm mt-1 block w-full"
                                rows="3">{{ old('observaciones', '') }}</textarea>
                            @error('observaciones')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if (isset($user) && $user->hijos->count())
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label
                                    class="block font-medium text-sm text-gray-700">{{ __('Fills associats') }}</label>
                                <ul class="mt-2 list-disc list-inside text-sm text-gray-800">
                                    @foreach ($user->hijos as $hijo)
                                        <li>{{ $hijo->name }} ({{ $hijo->email }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <input type="hidden" id="uuid" name="uuid"
                            value="{{ Ramsey\Uuid\Uuid::uuid4()->toString() }}" />

                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                @if (isset($user))
                                    {{ __('Actualitzar') }}
                                @else
                                    {{ __('Guardar') }}
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="height: 75px">

    </div>

    <footer
        class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow dark:bg-gray-800 dark:border-gray-600">
        <div class="flex justify-around items-center py-3">

            <!-- Botón Back to List -->
            <a href="{{ route('users.index') }}"
                class="flex flex-col items-center text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition">
                <svg width="32px" height="32px" viewBox="0 0 28 28" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                        <title>ic_fluent_people_team_28_regular</title>
                        <desc>Created with Sketch.</desc>
                        <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none"
                            fill-rule="evenodd">
                            <g id="ic_fluent_people_team_28_regular" fill="#08466d" fill-rule="nonzero">
                                <path
                                    d="M17.2540247,11 C18.4966654,11 19.5040247,12.0073593 19.5040247,13.25 L19.5040247,19.4989513 C19.5040247,22.5370966 17.0411213,25 14.002976,25 C10.9648308,25 8.50192738,22.5370966 8.50192738,19.4989513 L8.50192738,13.25 C8.50192738,12.0073593 9.5092867,11 10.7519274,11 L17.2540247,11 Z M17.2540247,12.5 L10.7519274,12.5 C10.3377138,12.5 10.0019274,12.8357864 10.0019274,13.25 L10.0019274,19.4989513 C10.0019274,21.7086695 11.7932579,23.5 14.002976,23.5 C16.2126942,23.5 18.0040247,21.7086695 18.0040247,19.4989513 L18.0040247,13.25 C18.0040247,12.8357864 17.6682382,12.5 17.2540247,12.5 Z M4.25,11 L8.40645343,11.000271 C8.01177565,11.4116389 7.72426829,11.9266236 7.58881197,12.5003444 L4.25,12.5 C3.83578644,12.5 3.5,12.8357864 3.5,13.25 L3.5,18.49876 C3.5,20.1562991 4.8437009,21.5 6.50123996,21.5 C6.94210796,21.5 7.36077379,21.4049412 7.73785924,21.2342019 C7.87129592,21.7236075 8.06231805,22.1898881 8.30186513,22.6257307 C7.75085328,22.8662539 7.14166566,23 6.50123996,23 C4.01527377,23 2,20.9847262 2,18.49876 L2,13.25 C2,12.0073593 3.00735931,11 4.25,11 Z M23.75,11 C24.9926407,11 26,12.0073593 26,13.25 L26,18.5 C26,20.9852814 23.9852814,23 21.5,23 C20.8609276,23 20.2529701,22.8667819 19.7023824,22.6266008 L19.7581025,22.5253735 C19.9721624,22.119151 20.1444731,21.6875096 20.2693267,21.2361575 C20.6437791,21.4056508 21.0608713,21.5 21.5,21.5 C23.1568542,21.5 24.5,20.1568542 24.5,18.5 L24.5,13.25 C24.5,12.8357864 24.1642136,12.5 23.75,12.5 L20.4171401,12.5003444 C20.2816838,11.9266236 19.9941764,11.4116389 19.5994986,11.000271 L23.75,11 Z M14,3 C15.9329966,3 17.5,4.56700338 17.5,6.5 C17.5,8.43299662 15.9329966,10 14,10 C12.0670034,10 10.5,8.43299662 10.5,6.5 C10.5,4.56700338 12.0670034,3 14,3 Z M22.0029842,4 C23.6598384,4 25.0029842,5.34314575 25.0029842,7 C25.0029842,8.65685425 23.6598384,10 22.0029842,10 C20.3461299,10 19.0029842,8.65685425 19.0029842,7 C19.0029842,5.34314575 20.3461299,4 22.0029842,4 Z M5.99701582,4 C7.65387007,4 8.99701582,5.34314575 8.99701582,7 C8.99701582,8.65685425 7.65387007,10 5.99701582,10 C4.34016157,10 2.99701582,8.65685425 2.99701582,7 C2.99701582,5.34314575 4.34016157,4 5.99701582,4 Z M14,4.5 C12.8954305,4.5 12,5.3954305 12,6.5 C12,7.6045695 12.8954305,8.5 14,8.5 C15.1045695,8.5 16,7.6045695 16,6.5 C16,5.3954305 15.1045695,4.5 14,4.5 Z M22.0029842,5.5 C21.1745571,5.5 20.5029842,6.17157288 20.5029842,7 C20.5029842,7.82842712 21.1745571,8.5 22.0029842,8.5 C22.8314113,8.5 23.5029842,7.82842712 23.5029842,7 C23.5029842,6.17157288 22.8314113,5.5 22.0029842,5.5 Z M5.99701582,5.5 C5.16858869,5.5 4.49701582,6.17157288 4.49701582,7 C4.49701582,7.82842712 5.16858869,8.5 5.99701582,8.5 C6.82544294,8.5 7.49701582,7.82842712 7.49701582,7 C7.49701582,6.17157288 6.82544294,5.5 5.99701582,5.5 Z"
                                    id="🎨-Color"> </path>
                            </g>
                        </g>
                    </g>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Tornar al llistat') }}</span>
            </a>

            <!-- Botón Eliminar Músico -->
            @if (isset($user))
                <form action="{{ route('users.destroy', $user->id) }}" method="post"
                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este músico?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex flex-col items-center text-gray-700 hover:text-red-600 dark:text-gray-300 dark:hover:text-red-400 transition">
                        <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                <title>ic_fluent_person_delete_24_regular</title>
                                <desc>Created with Sketch.</desc>
                                <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none"
                                    fill-rule="evenodd">
                                    <g id="ic_fluent_person_delete_24_regular" fill="#7a0000" fill-rule="nonzero">
                                        <path
                                            d="M17.5,12 C20.5375661,12 23,14.4624339 23,17.5 C23,20.5375661 20.5375661,23 17.5,23 C14.4624339,23 12,20.5375661 12,17.5 C12,14.4624339 14.4624339,12 17.5,12 Z M12.0222607,13.9993086 C11.7255613,14.4626083 11.4860296,14.9660345 11.3136172,15.4996352 L4.25354153,15.499921 C3.83932796,15.499921 3.50354153,15.8357075 3.50354153,16.249921 L3.50354153,17.1572408 C3.50354153,17.8128951 3.78953221,18.4359296 4.28670709,18.8633654 C5.5447918,19.9450082 7.44080155,20.5010712 10,20.5010712 C10.598839,20.5010712 11.1614445,20.4706245 11.6881394,20.4101192 C11.9370538,20.9102887 12.2508544,21.3740111 12.6170965,21.7904935 C11.8149076,21.9312924 10.9419626,22.0010712 10,22.0010712 C7.11050247,22.0010712 4.87168436,21.3444691 3.30881727,20.0007885 C2.48019625,19.2883988 2.00354153,18.2500002 2.00354153,17.1572408 L2.00354153,16.249921 C2.00354153,15.0072804 3.01090084,13.999921 4.25354153,13.999921 L12.0222607,13.9993086 Z M15.0930472,14.9662824 L15.0237993,15.0241379 L14.9659438,15.0933858 C14.8478223,15.2638954 14.8478223,15.4914871 14.9659438,15.6619968 L15.0237993,15.7312446 L16.7933527,17.5006913 L15.0263884,19.2674911 L14.968533,19.3367389 C14.8504114,19.5072486 14.8504114,19.7348403 14.968533,19.9053499 L15.0263884,19.9745978 L15.0956363,20.0324533 C15.2661459,20.1505748 15.4937377,20.1505748 15.6642473,20.0324533 L15.7334952,19.9745978 L17.5003527,18.2076913 L19.2693951,19.9768405 L19.338643,20.0346959 C19.5091526,20.1528175 19.7367444,20.1528175 19.907254,20.0346959 L19.9765019,19.9768405 L20.0343574,19.9075926 C20.1524789,19.737083 20.1524789,19.5094912 20.0343574,19.3389816 L19.9765019,19.2697337 L18.2073527,17.5006913 L19.9792686,15.7312918 L20.0371241,15.6620439 C20.1552456,15.4915343 20.1552456,15.2639425 20.0371241,15.0934329 L19.9792686,15.024185 L19.9100208,14.9663296 C19.7395111,14.848208 19.5119194,14.848208 19.3414098,14.9663296 L19.2721619,15.024185 L17.5003527,16.7936913 L15.7309061,15.0241379 L15.6616582,14.9662824 C15.5155071,14.8650354 15.3274181,14.8505715 15.1692847,14.9228908 L15.0930472,14.9662824 L15.0930472,14.9662824 Z M10,2.0046246 C12.7614237,2.0046246 15,4.24320085 15,7.0046246 C15,9.76604835 12.7614237,12.0046246 10,12.0046246 C7.23857625,12.0046246 5,9.76604835 5,7.0046246 C5,4.24320085 7.23857625,2.0046246 10,2.0046246 Z M10,3.5046246 C8.06700338,3.5046246 6.5,5.07162798 6.5,7.0046246 C6.5,8.93762123 8.06700338,10.5046246 10,10.5046246 C11.9329966,10.5046246 13.5,8.93762123 13.5,7.0046246 C13.5,5.07162798 11.9329966,3.5046246 10,3.5046246 Z"
                                            id="🎨-Color"> </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <span class="text-xs mt-1 font-bold text-red-600">{{ __('Delete') }}</span>
                    </button>
                </form>
            @endif
        </div>
    </footer>

</x-app-layout>
