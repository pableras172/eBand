<div class="max-w-5xl mx-auto py-2 px-2 pb-24 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900">Editar anuncio</h2>
    </x-slot>

    <div class="rounded-xl bg-white p-4 shadow-sm sm:p-6">
        <form wire:submit="save" class="space-y-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700">Título</label>
                    <input type="text" wire:model="title"
                        class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" />
                    @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700">Texto</label>
                    <div class="rounded-md border border-gray-300">
                        <div class="flex flex-wrap gap-2 border-b border-gray-200 bg-gray-50 p-2 text-xs">
                            <button type="button" data-editor-target="announcement-body-edit" data-wrap="<strong>|</strong>" class="rounded border border-gray-300 bg-white px-2 py-1 font-semibold text-gray-700">Negrita</button>
                            <button type="button" data-editor-target="announcement-body-edit" data-wrap="<em>|</em>" class="rounded border border-gray-300 bg-white px-2 py-1 font-semibold text-gray-700">Cursiva</button>
                            <button type="button" data-editor-target="announcement-body-edit" data-wrap="<u>|</u>" class="rounded border border-gray-300 bg-white px-2 py-1 font-semibold text-gray-700">Subrayado</button>
                            <button type="button" data-editor-target="announcement-body-edit" data-wrap="<h3>|</h3>" class="rounded border border-gray-300 bg-white px-2 py-1 font-semibold text-gray-700">Título</button>
                            <button type="button" data-editor-target="announcement-body-edit" data-wrap="<ul><li>|</li></ul>" class="rounded border border-gray-300 bg-white px-2 py-1 font-semibold text-gray-700">Lista</button>
                            <button type="button" data-editor-target="announcement-body-edit" data-wrap="<blockquote>|</blockquote>" class="rounded border border-gray-300 bg-white px-2 py-1 font-semibold text-gray-700">Cita</button>
                        </div>

                        <textarea id="announcement-body-edit" wire:model="body" rows="8"
                            class="w-full border-0 text-sm shadow-none focus:ring-0"></textarea>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Puedes aplicar formato básico. El contenido se limpia automáticamente al guardar.</p>
                    @error('body')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700">Vista Blade opcional</label>
                    <input type="text" wire:model="content_view" placeholder="announcements.mi-anuncio"
                        class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" />
                    @error('content_view')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Inicio</label>
                    <input type="datetime-local" wire:model="starts_at"
                        class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" />
                    @error('starts_at')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Fin</label>
                    <input type="datetime-local" wire:model="ends_at"
                        class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" />
                    @error('ends_at')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700">URL opcional tras "He leído"</label>
                    <input type="url" wire:model="redirect_url" placeholder="https://..."
                        class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" />
                    @error('redirect_url')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 p-4">
                <div class="flex items-start gap-3">
                    <input id="applies_to_all" type="checkbox" wire:model.live="applies_to_all" class="mt-1 rounded border-gray-300 text-cyan-600 focus:ring-cyan-500" />
                    <div>
                        <label for="applies_to_all" class="text-sm font-semibold text-gray-800">Enviar a todos los usuarios</label>
                        <p class="text-xs text-gray-500">Si lo desactivas, podrás elegir instrumentos concretos.</p>
                    </div>
                </div>

                @if (! $applies_to_all)
                    <div class="mt-4">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Instrumentos destino</label>
                        <select multiple wire:model="instrument_ids"
                            class="h-40 w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                            @foreach ($instruments as $instrument)
                                <option value="{{ $instrument->id }}">{{ $instrument->name }}</option>
                            @endforeach
                        </select>
                        @error('instrument_ids')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                @endif
            </div>

            <div class="flex items-start gap-3">
                <input id="is_active" type="checkbox" wire:model="is_active" class="mt-1 rounded border-gray-300 text-cyan-600 focus:ring-cyan-500" />
                <label for="is_active" class="text-sm font-medium text-gray-700">Anuncio activo</label>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('announcements.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Cancelar</a>
                <button type="submit" class="rounded-md bg-cyan-600 px-4 py-2 text-sm font-semibold text-white hover:bg-cyan-500">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
