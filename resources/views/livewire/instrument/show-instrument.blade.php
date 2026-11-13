<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12 0c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Instruments') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Llistat d\'Instruments') }}
                    </h1>
                    <p class="mt-0.5 text-xs text-slate-500">
                        {{ __('Instruments registrats') }}: {{ count($intruments) }}
                    </p>
                </div>
            </div>

            <a href="{{ route('instrument.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ __('Nou instrument') }}</span>
            </a>
        </div>
    </x-slot>

    @if (session()->has('message') || (request()->has('success') && request()->success))
        <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 mt-4">
            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('message') ?? __('El instrument s\'ha eliminat correctament') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 ml-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 space-y-6 pb-28">
        <div class="overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
            <table class="min-w-full divide-y divide-indigo-50 w-full">
                <thead>
                    <tr class="bg-[#EEF1FA]/60">
                        <th scope="col"
                            class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Nom') }}
                        </th>
                        <th scope="col"
                            class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider ">
                            {{ __('Imatge') }}
                        </th>
                        <th scope="col"
                            class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider ">
                            {{ __('Ordre') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-indigo-50/70" id="instrumentTable">
                    @foreach ($intruments as $index => $intrument)
                        <tr data-id="{{ $intrument->id }}"
                            data-url="{{ route('instrument.show', $intrument->id) }}"
                            class="instrument-row cursor-pointer hover:bg-indigo-50/30 transition-colors"
                            draggable="true">
                            <td class="px-4 py-3.5 whitespace-nowrap text-sm font-bold text-center text-slate-900">
                                {{ $intrument->name }}
                            </td>

                            <td class="px-4 py-3.5 whitespace-nowrap text-sm text-center align-middle text-slate-900">
                                <div class="flex justify-center items-center">
                                    @if ($intrument->icon)
                                        <img src="{{ asset('storage/imagenes/instruments/' . $intrument->icon) }}"
                                            alt="{{ $intrument->name }}" class="rounded-full border border-indigo-100 shadow-xs"
                                            style="width: 44px; height: 44px;">
                                    @else
                                        <x-nophoto w="40" h="40" />
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3.5 whitespace-nowrap text-sm text-center text-slate-900">
                                <span class="orden inline-block px-3 py-1 rounded-xl bg-[#F5F6FC] border border-indigo-100 text-xs font-bold text-indigo-700">{{ $intrument->orden }}</span>
                            </td>                                       
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-statistics.instruments />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tbody = document.getElementById('instrumentTable');
            let draggedRow = null;
            let dragging = false;

            function buildOrder() {
                return Array.from(tbody.querySelectorAll('.instrument-row')).map((r, idx) => ({
                    id: r.dataset.id,
                    orden: idx + 1
                }));
            }

            function updateOrdenNumbers(order) {
                order.forEach(o => {
                    const el = tbody.querySelector(`tr[data-id="${o.id}"] .orden`);
                    if (el) el.textContent = o.orden;
                });
            }

            function sendOrder(ordenes) {
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('/update-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            ordenes: ordenes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        showToast(data);
                    })
                    .catch(error => {
                        console.error('Error al actualizar el orden:', error);
                    });
            }


            function attachDesktopDnD(row) {
                row.addEventListener('dragstart', (e) => {
                    draggedRow = row;
                    dragging = true;
                    row.classList.add('opacity-50');
                    e.dataTransfer.effectAllowed = 'move';
                });

                row.addEventListener('dragend', () => {
                    row.classList.remove('opacity-50');
                    draggedRow = null;
                    // pequeña demora para no captar el click posterior al drop
                    setTimeout(() => dragging = false, 50);
                });

                row.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    row.classList.add('ring-2', 'ring-indigo-300');
                });

                row.addEventListener('dragleave', () => {
                    row.classList.remove('ring-2', 'ring-indigo-300');
                });

                row.addEventListener('drop', (e) => {
                    e.preventDefault();
                    row.classList.remove('ring-2', 'ring-indigo-300');
                    if (!draggedRow || draggedRow === row) return;

                    const rect = row.getBoundingClientRect();
                    const isAfter = e.clientY > rect.top + rect.height / 2;

                    if (isAfter) {
                        row.parentNode.insertBefore(draggedRow, row.nextSibling);
                    } else {
                        row.parentNode.insertBefore(draggedRow, row);
                    }

                    const order = buildOrder();
                    updateOrdenNumbers(order);
                    sendOrder(order);
                });
            }

            // Touch support (móvil)
            function attachTouchDnD(row) {
                row.style.touchAction = 'none';
                row.classList.add('select-none');

                let pointerDown = false;
                let startY = 0;

                row.addEventListener('touchstart', (e) => {
                    pointerDown = true;
                    draggedRow = row;
                    dragging = false;
                    startY = e.touches[0].clientY;
                    row.classList.add('opacity-50');
                }, { passive: true });

                row.addEventListener('touchmove', (e) => {
                    if (!pointerDown || !draggedRow) return;
                    const touch = e.touches[0];
                    if (Math.abs(touch.clientY - startY) > 8) dragging = true;

                    const targetEl = document.elementFromPoint(touch.clientX, touch.clientY);
                    const targetRow = targetEl ? targetEl.closest('tr.instrument-row') : null;

                    if (!targetRow || targetRow === draggedRow) return;

                    const rect = targetRow.getBoundingClientRect();
                    const isAfter = touch.clientY > rect.top + rect.height / 2;

                    if (isAfter) {
                        targetRow.parentNode.insertBefore(draggedRow, targetRow.nextSibling);
                    } else {
                        targetRow.parentNode.insertBefore(draggedRow, targetRow);
                    }
                }, { passive: true });

                row.addEventListener('touchend', () => {
                    if (!pointerDown) return;
                    pointerDown = false;
                    row.classList.remove('opacity-50');

                    if (dragging) {
                        const order = buildOrder();
                        updateOrdenNumbers(order);
                        sendOrder(order);
                    }

                    draggedRow = null;
                    // reset estado tras finalización de gesto
                    setTimeout(() => dragging = false, 50);
                });
            }

            const isTouch = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);

            tbody.querySelectorAll('.instrument-row').forEach(row => {
                // Desktop DnD
                row.setAttribute('draggable', 'true');
                attachDesktopDnD(row);

                // Navegación por click a edición
                row.addEventListener('click', (e) => {
                    if (dragging) return;
                    if (e.target.closest('a, button')) return;
                    const url = row.dataset.url;
                    if (url) window.location.href = url;
                });

                // Mobile DnD
                if (isTouch) {
                    row.removeAttribute('draggable');
                    attachTouchDnD(row);
                }
            });
        });
    </script>
</x-app-layout>
