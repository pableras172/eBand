@php
    $repertoireRows = old('repertoire', $repertoire ?? []);

    if (count($repertoireRows) === 0) {
        $repertoireRows = [
            ['title' => '', 'author' => '', 'details' => '', 'url' => '', 'sort_order' => 1],
        ];
    }
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Titulo</label>
            <input id="title" name="title" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('title', $program->title) }}">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="location" class="block text-sm font-medium text-gray-700">Ubicacion</label>
            <input id="location" name="location" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('location', $program->location) }}">
            @error('location')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="event_date" class="block text-sm font-medium text-gray-700">Fecha</label>
            <input id="event_date" name="event_date" type="date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('event_date', optional($program->event_date)->format('Y-m-d')) }}">
            @error('event_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="event_time" class="block text-sm font-medium text-gray-700">Hora</label>
            <input id="event_time" name="event_time" type="time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('event_time', $program->event_time ? substr((string) $program->event_time, 0, 5) : null) }}">
            @error('event_time')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="participants" class="block text-sm font-medium text-gray-700">Participantes (opcional)</label>
        <textarea id="participants" name="participants" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('participants', $program->participants) }}</textarea>
        @error('participants')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-4 rounded-lg border border-gray-200 p-4 md:grid-cols-2">
        <label class="inline-flex items-start gap-3">
            <input type="checkbox" name="is_published" value="1" class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" @checked(old('is_published', $program->is_published))>
            <span>
                <span class="block text-sm font-medium text-gray-800">Publicado</span>
                <span class="block text-xs text-gray-500">Solo los programas publicados aparecen en /programa.</span>
            </span>
        </label>

        <label class="inline-flex items-start gap-3">
            <input type="checkbox" name="is_featured" value="1" class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" @checked(old('is_featured', $program->is_featured))>
            <span>
                <span class="block text-sm font-medium text-gray-800">Destacar manualmente</span>
                <span class="block text-xs text-gray-500">Si está activo, este programa tendrá prioridad en la URL pública.</span>
            </span>
        </label>

        @error('is_published')
            <p class="text-sm text-red-600 md:col-span-2">{{ $message }}</p>
        @enderror

        @error('is_featured')
            <p class="text-sm text-red-600 md:col-span-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Imagen principal (opcional)</label>
            <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-600">
            @if ($program->image_path)
                <p class="mt-2 text-xs text-gray-500">Actual: {{ $program->image_path }}</p>
            @endif
            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="logo_1" class="block text-sm font-medium text-gray-700">Logo 1 (opcional)</label>
            <input id="logo_1" name="logo_1" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-600">
            @if ($program->logo_1_path)
                <p class="mt-2 text-xs text-gray-500">Actual: {{ $program->logo_1_path }}</p>
            @endif
            @error('logo_1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="logo_2" class="block text-sm font-medium text-gray-700">Logo 2 (opcional)</label>
            <input id="logo_2" name="logo_2" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-600">
            @if ($program->logo_2_path)
                <p class="mt-2 text-xs text-gray-500">Actual: {{ $program->logo_2_path }}</p>
            @endif
            @error('logo_2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="logo_3" class="block text-sm font-medium text-gray-700">Logo 3 (opcional)</label>
            <input id="logo_3" name="logo_3" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-600">
            @if ($program->logo_3_path)
                <p class="mt-2 text-xs text-gray-500">Actual: {{ $program->logo_3_path }}</p>
            @endif
            @error('logo_3')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <div class="mb-3 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Repertorio</h3>
            <button type="button" id="add-piece" class="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-indigo-700">Agregar obra</button>
        </div>

        @error('repertoire')
            <p class="mb-3 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div id="repertoire-list" class="space-y-4">
            @foreach ($repertoireRows as $index => $piece)
                <div class="piece-row rounded-lg border border-gray-200 p-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Titulo</label>
                            <input name="repertoire[{{ $index }}][title]" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ $piece['title'] ?? '' }}">
                            @error('repertoire.'.$index.'.title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Autor</label>
                            <input name="repertoire[{{ $index }}][author]" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ $piece['author'] ?? '' }}">
                            @error('repertoire.'.$index.'.author')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Orden</label>
                            <input name="repertoire[{{ $index }}][sort_order]" type="number" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ $piece['sort_order'] ?? ($index + 1) }}">
                            @error('repertoire.'.$index.'.sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Detalles (opcional)</label>
                        <textarea name="repertoire[{{ $index }}][details]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $piece['details'] ?? '' }}</textarea>
                        @error('repertoire.'.$index.'.details')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">URL audio (opcional)</label>
                        <input name="repertoire[{{ $index }}][url]" type="url" placeholder="https://..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ $piece['url'] ?? '' }}">
                        @error('repertoire.'.$index.'.url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-3 flex justify-end">
                        <button type="button" class="remove-piece rounded-md border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50">Eliminar</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('concert-programs.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Volver</a>
        <button type="submit" class="rounded-md bg-gray-900 px-5 py-2 text-sm font-semibold text-white hover:bg-black">{{ $submitLabel }}</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const repertoireList = document.getElementById('repertoire-list');
        const addButton = document.getElementById('add-piece');

        if (!repertoireList || !addButton) {
            return;
        }

        const rowTemplate = function (index) {
            return `
                <div class="piece-row rounded-lg border border-gray-200 p-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Titulo</label>
                            <input name="repertoire[${index}][title]" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Autor</label>
                            <input name="repertoire[${index}][author]" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Orden</label>
                            <input name="repertoire[${index}][sort_order]" type="number" min="1" value="${index + 1}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Detalles (opcional)</label>
                        <textarea name="repertoire[${index}][details]" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">URL audio (opcional)</label>
                        <input name="repertoire[${index}][url]" type="url" placeholder="https://..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mt-3 flex justify-end">
                        <button type="button" class="remove-piece rounded-md border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50">Eliminar</button>
                    </div>
                </div>
            `;
        };

        const refreshDeleteButtons = function () {
            const rows = repertoireList.querySelectorAll('.piece-row');
            rows.forEach(function (row) {
                const removeButton = row.querySelector('.remove-piece');
                if (!removeButton) {
                    return;
                }

                removeButton.onclick = function () {
                    if (repertoireList.querySelectorAll('.piece-row').length > 1) {
                        row.remove();
                    }
                };
            });
        };

        addButton.addEventListener('click', function () {
            const newIndex = repertoireList.querySelectorAll('.piece-row').length;
            repertoireList.insertAdjacentHTML('beforeend', rowTemplate(newIndex));
            refreshDeleteButtons();
        });

        refreshDeleteButtons();
    });
</script>
