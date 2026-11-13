<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-8.25A2.25 2.25 0 0017.25 3.75H6.75A2.25 2.25 0 004.5 6v12a2.25 2.25 0 002.25 2.25h7.5m-6-12h7.5m-7.5 4.5h4.5m5.25 2.25v6m3-3h-6" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Contractes') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Llistat de contractes') }}
                    </h1>
                    <p class="mt-0.5 text-xs text-slate-500">
                        {{ __('Contratos activos') }}: {{ $contratos->total() }}
                    </p>
                </div>
            </div>

            <a href="{{ route('contratos.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ __('Nou contracte') }}</span>
            </a>
        </div>
    </x-slot>

    {{-- creado --}}
    @if (session()->has('success'))
        <div class="flash-alert bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 mb-4 rounded-2xl text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- eliminado --}}
    @if (session()->has('deletesuccess'))
        <div class="flash-alert bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 mb-4 rounded-2xl text-xs font-semibold"
            role="alert">
            <strong class="font-bold">{{ __('Contracte eliminat') }}:</strong>
            <span>{{ session('deletesuccess') }}</span>
        </div>
    @endif

    {{-- duplicado --}}
    @if (session()->has('duplicatesuccess'))
        <div class="flash-alert transition-opacity duration-700 ease-out bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 mb-4 rounded-2xl text-xs font-semibold">
            {{ session('duplicatesuccess') }}
        </div>
    @endif

    <div class="container mx-auto py-2 px-2 pb-28 sm:px-6 lg:px-0">
        <div class="container mx-auto py-2 px-2 sm:px-6 lg:px-0">
            <div class="mb-4 rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <form method="GET" action="{{ route('contratos.anyo', $year) }}" class="flex w-full flex-col gap-3 sm:flex-row lg:max-w-2xl">
                        <div class="relative flex-1">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0Z" />
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                placeholder="{{ __('Busca por población, descripción o contacto') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 pl-11 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        </div>
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-indigo-700">
                            {{ __('Search') }}
                        </button>
                    </form>

                    <div class="flex items-center justify-end gap-3">
                        <select id="yearSelect"
                            class="appearance-none rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-4 py-2.5 pr-8 text-xs font-bold text-slate-700 shadow-xs transition hover:border-indigo-200 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @for ($i = date('Y') - 3; $i <= date('Y') + 2; $i++)
                                <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
        </div>

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
                        <table class="min-w-full divide-y divide-indigo-50 w-full">
                            <thead>
                                <tr class="bg-[#EEF1FA]/60">
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider md:table-cell">
                                        {{ __('Població') }}
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        {{ __('Descripció') }}
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">
                                        {{ __('Data Inici') }}
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">
                                        {{ __('Data de Fi') }}
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{ __('Contacte') }}
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{ __('Accions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($contratos as $contrato)
                                    <tr class="cursor-pointer transition hover:bg-cyan-50/60"
                                        data-url="{{ route('contratos.edit', $contrato->id) }}">
                                        <td class="px-2 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            {{ $contrato->poblacion }}
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap text-sm text-gray-700 md:table-cell">
                                            <span class="block max-w-[5rem] truncate break-words md:max-w-none md:whitespace-normal">
                                                {{ $contrato->descripcion }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-2 py-3 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                            {{ $contrato->fechainicio ? \Carbon\Carbon::parse($contrato->fechainicio)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td
                                            class="px-2 py-3 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                            {{ $contrato->fechafin ? \Carbon\Carbon::parse($contrato->fechafin)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td
                                            class="px-2 py-3 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                            {{ $contrato->contacto }}
                                        </td>
                                        <td class="px-2 py-3 whitespace-nowrap text-sm font-medium hidden md:table-cell">
                                            <div class="flex justify-center items-center space-x-2">
                                                <a href="{{ route('contratos.edit', $contrato->id) }}" class="rounded-xl p-1 transition hover:bg-gray-100">
                                                    <x-editar w="24" h="24" />
                                                </a>
                                                <a href="{{ route('contratos.actuaciones.index', ['contrato' => $contrato->id]) }}"
                                                    class="rounded-xl p-1 transition hover:bg-gray-100">
                                                    <x-calendario w="24" h="24" />
                                                </a>
                                                <a href="{{ route('contratos.duplicate', $contrato->id) }}" class="rounded-xl p-1 transition hover:bg-gray-100">
                                                    <x-duplicar w="24" h="24" />
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="mx-auto max-w-md">
                                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 7.5h16.5M6.75 3.75h10.5A2.25 2.25 0 0119.5 6v12a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 18V6a2.25 2.25 0 012.25-2.25Z" />
                                                    </svg>
                                                </div>
                                                <p class="mt-4 text-base font-semibold text-gray-900">{{ __('Sin resultados') }}</p>
                                                <p class="mt-1 text-sm text-gray-500">{{ __('No hay contratos para este filtro.') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="border-t border-gray-200 px-4 py-4">
                            {{ $contratos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('yearSelect').addEventListener('change', function() {
            var year = this.value;
            var params = new URLSearchParams(window.location.search);
            var search = params.get('search');
            var targetUrl = "/contratos/year/" + year;

            if (search) {
                targetUrl += "?search=" + encodeURIComponent(search);
            }

            window.location.href = targetUrl;
        });

        // Ocultar mensajes flash con fade-out
        window.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.flash-alert');
            const fadeDurationMs = 700; // debe coincidir con duration-700

            alerts.forEach(el => {
                setTimeout(() => {
                    el.classList.add('opacity-0'); // inicia el fade-out
                    setTimeout(() => el.classList.add('hidden'), fadeDurationMs); // oculta tras el fade
                }, 4000); // espera visible antes de empezar el fade
            });

            document.querySelectorAll('tbody tr[data-url]').forEach(row => {
                row.addEventListener('click', (e) => {
                    if (e.target.closest('a, button')) return;
                    window.location.href = row.dataset.url;
                });
            });
        });


    </script>

    <footer
        class="fixed bottom-0 left-0 z-20 w-full bg-white/90 backdrop-blur-2xl border-t border-indigo-100/80 shadow-glass">
        <div class="flex justify-center items-center py-3">
            <!-- Botón Nou Contracte -->
            <a href="{{ route('contratos.create') }}"
                class="flex flex-col items-center text-slate-600 hover:text-indigo-600 transition">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-xs mt-1 font-bold text-slate-700">{{ __('Nou contracte') }}</span>
            </a>
        </div>
    </footer>
        </div>
    </footer>

</x-app-layout>
