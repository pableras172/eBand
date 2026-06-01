<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Programas de concierto
            </h2>
            <div class="flex items-center gap-2">
                <form action="{{ route('concert-programs.download-qr') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-md border border-indigo-300 bg-white px-4 py-2 text-sm font-semibold text-indigo-700 hover:bg-indigo-50">
                        Descargar QR /programa
                    </button>
                </form>
                <a href="{{ route('concert-programs.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Nuevo programa
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (session('success_message'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success_message') }}
                </div>
            @endif

            @if (session('error_message'))
                <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    {{ session('error_message') }}
                </div>
            @endif

            <div class="mb-4 rounded-md border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                URL publica para QR:
                <a href="{{ route('concert-programs.public') }}" class="font-semibold underline" target="_blank" rel="noopener">
                    {{ route('concert-programs.public') }}
                </a>
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Titulo</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Hora</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Ubicacion</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Obras</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($programs as $program)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $program->title }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ optional($program->event_date)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ substr((string) $program->event_time, 0, 5) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $program->location }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    @if ($program->is_published)
                                        <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">Publicado</span>
                                    @else
                                        <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">Borrador</span>
                                    @endif

                                    @if ($program->is_featured)
                                        <span class="ml-1 rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">Destacado</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $program->pieces_count }}</td>
                                <td class="px-4 py-3 text-right text-sm space-x-3">
                                    <a href="{{ route('concert-programs.poster.preview', $program) }}" class="font-medium text-sky-600 hover:text-sky-800" target="_blank" rel="noopener">Cartel A4</a>
                                    <a href="{{ route('concert-programs.edit', $program) }}" class="font-medium text-indigo-600 hover:text-indigo-800">Editar</a>
                                    <form action="{{ route('concert-programs.destroy', $program) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que quieres eliminar este programa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-800">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">Todavia no hay programas de concierto.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $programs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
