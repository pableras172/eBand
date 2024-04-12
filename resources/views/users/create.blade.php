<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nou Music
        </h2>
    </x-slot>

    <div>
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                @if(isset($user))
                    <form action="{{ route('users.destroy', $user->id) }}" method="post"
                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este musico?')">
                        @csrf
                        @method('DELETE')
                        <div class="block text-right">
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                <!-- Cambiamos el texto por un ícono de papelera -->
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                @endif


                <form method="post" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="name" class="block font-medium text-sm text-gray-700">Nom</label>
                            <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ isset($user) ? $user->name : old('name') }}" />
                            @error('name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input type="email" name="email" id="email" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ isset($user) ? $user->email : old('email') }}" />
                            @error('email')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                            <input type="password" name="password" id="password" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ isset($user) ? '' : 'Banda2024' }}" />
                            <span class="text-sm text-gray-500">Valor predeterminado: Banda2024 (Puedes cambiarlo)</span>
                            @error('password')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="instrument" class="block font-medium text-sm text-gray-700">Instrument</label>
                            <select name="instrument_id" id="instrument" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                @foreach($instruments as $instrument)
                                    <option value="{{ $instrument->id }}" {{ isset($user) && $user->instrument_id == $instrument->id ? 'selected' : '' }}>{{ $instrument->name }}</option>
                                @endforeach
                            </select>
                            @error('instrument_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="telefono" class="block font-medium text-sm text-gray-700">Telefon</label>
                            <input type="text" name="telefono" id="telefono" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ isset($user) ? $user->telefono : old('telefono') }}" />
                            @error('telefono')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="porcentaje" class="block font-medium text-sm text-gray-700">Percentaje</label>
                            <input type="number" name="porcentaje" id="porcentaje" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ isset($user) ? $user->porcentaje : old('porcentaje') }}" />
                            @error('porcentaje')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="forastero" class="block font-medium text-sm text-gray-700">Foraster</label>
                            <input type="checkbox" name="forastero" id="forastero" class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out" {{ (isset($user) && $user->forastero) || old('forastero') ? 'checked' : '' }}>
                            @error('forastero')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="activo" class="block font-medium text-sm text-gray-700">Actiu</label>
                            <input type="checkbox" name="activo" id="activo" class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out" {{ (isset($user) && $user->activo) || old('activo') ? 'checked' : '' }}>
                            @error('activo')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="fechaAlta" class="block font-medium text-sm text-gray-700">Data Alta</label>
                            <input type="date" name="fechaAlta" id="fechaAlta" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ isset($user) ? $user->fechaAlta : old('fechaAlta') }}" />
                            @error('fechaAlta')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="roles" class="block font-medium text-sm text-gray-700">Rols</label>
                            <select name="roles[]" id="roles" class="form-multiselect block rounded-md shadow-sm mt-1 block w-full" multiple="multiple">
                                @foreach($roles as $id => $role)
                                    <option value="{{ $id }}"{{ isset($user) && $user->roles->contains($id) ? ' selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        

                            <div class="px-4 py-5 bg-white sm:p-6">
                                <label for="observaciones" class="block font-medium text-sm text-gray-700">Observacions</label>
                                <textarea name="observaciones" id="observaciones" class="form-textarea rounded-md shadow-sm mt-1 block w-full" rows="3">{{ old('observaciones', '') }}</textarea>
                                @error('observaciones')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <input type="hidden" id="uuid" name="uuid" value="{{ Ramsey\Uuid\Uuid::uuid4()->toString() }}" />

                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                @if(isset($user))
                                    Actualitzar
                                @else
                                    Guardar
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
