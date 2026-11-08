<div class="max-w-5xl mx-auto py-4 px-2 pb-24 sm:px-6 lg:px-8 space-y-6">
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.actividades.index') }}" class="hover:text-cyan-600 transition">{{ __('actividades.title') }}</a>
                    <span>/</span>
                    <span class="text-gray-700 font-medium">{{ $isEditing ? __('actividades.edit_title') : __('actividades.create_title') }}</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $isEditing ? __('actividades.edit_title') . ": {$actividad->titulo}" : __('actividades.create_title') }}
                </h1>
            </div>
            <a href="{{ route('admin.actividades.index') }}"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                {{ __('actividades.back') }}
            </a>
        </div>
    </x-slot>

    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 space-y-1 shadow-sm">
            <p class="font-bold flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ __('Por favor, revisa els errors:') }}
            </p>
            <ul class="list-disc list-inside text-xs space-y-0.5 pl-7">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        <!-- Tarjeta de Datos Generales -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 space-y-5">
            <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                <span>📌</span> {{ __('Dades de l’esdeveniment') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Título -->
                <div class="md:col-span-2">
                    <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Títol de l’activitat') }} <span class="text-rose-500">*</span>
                    </label>
                    <input id="titulo" type="text" wire:model="titulo" placeholder="Ex. Sopar Santa Cecília 2026, Dinar de Germanor, Viatge a..."
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm" />
                    @error('titulo') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Tipo -->
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Tipus d’activitat') }} <span class="text-rose-500">*</span>
                    </label>
                    <select id="tipo" wire:model.live="tipo"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm">
                        <option value="comida">🍽️ {{ __('actividades.types.comida') }}</option>
                        <option value="cena">🍷 {{ __('actividades.types.cena') }}</option>
                        <option value="concierto">🎺 {{ __('actividades.types.concierto') }}</option>
                        <option value="reunion">📋 {{ __('actividades.types.reunion') }}</option>
                        <option value="excursion">🚌 {{ __('actividades.types.excursion') }}</option>
                        <option value="otro">🎉 {{ __('actividades.types.otro') }}</option>
                    </select>
                    @error('tipo') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Estat de publicació') }} <span class="text-rose-500">*</span>
                    </label>
                    <select id="estado" wire:model="estado"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm">
                        <option value="borrador">{{ __('actividades.status.borrador') }}</option>
                        <option value="abierta">{{ __('actividades.status.abierta') }}</option>
                        <option value="cerrada">{{ __('actividades.status.cerrada') }}</option>
                    </select>
                    @error('estado') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Modalidad / Pago -->
                <div class="md:col-span-2 bg-slate-50/80 p-4 rounded-xl border border-slate-200">
                    <span class="block text-sm font-bold text-gray-900 mb-2">
                        {{ __('actividades.modality_title') }}
                    </span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-start p-3.5 rounded-xl border cursor-pointer transition {{ $es_de_pago ? 'bg-white border-cyan-500 ring-2 ring-cyan-500 shadow-xs' : 'bg-white/60 border-gray-200 hover:bg-white text-gray-600' }}">
                            <input type="radio" wire:model.live="es_de_pago" :value="true" class="sr-only">
                            <div class="flex items-start gap-3">
                                <span class="text-2xl mt-0.5">🏷️</span>
                                <div>
                                    <span class="block text-sm font-bold text-gray-900">{{ __('actividades.modality_paid_title') }}</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">{{ __('actividades.modality_paid_desc') }}</span>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex items-start p-3.5 rounded-xl border cursor-pointer transition {{ ! $es_de_pago ? 'bg-white border-cyan-500 ring-2 ring-cyan-500 shadow-xs' : 'bg-white/60 border-gray-200 hover:bg-white text-gray-600' }}">
                            <input type="radio" wire:model.live="es_de_pago" :value="false" class="sr-only">
                            <div class="flex items-start gap-3">
                                <span class="text-2xl mt-0.5">🎺</span>
                                <div>
                                    <span class="block text-sm font-bold text-gray-900">{{ __('actividades.modality_free_title') }}</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">{{ __('actividades.modality_free_desc') }}</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Fecha y hora del evento -->
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('actividades.event_date') }} <span class="text-rose-500">*</span>
                    </label>
                    <input id="fecha" type="datetime-local" wire:model="fecha"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm" />
                    @error('fecha') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Fecha límite de inscripción -->
                <div>
                    <label for="fecha_limite_inscripcion" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('actividades.deadline_label') }} <span class="text-rose-500">*</span>
                    </label>
                    <input id="fecha_limite_inscripcion" type="datetime-local" wire:model="fecha_limite_inscripcion"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm" />
                    @error('fecha_limite_inscripcion') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Lugar -->
                <div class="md:col-span-2">
                    <label for="lugar" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('actividades.place') }}
                    </label>
                    <input id="lugar" type="text" wire:model="lugar" placeholder="Ex. Restaurant El Portó, Plaça de l’Ajuntament..."
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm" />
                    @error('lugar') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Descripción e Información (con soporte HTML) -->
                <div class="md:col-span-2" x-data="{
                    tab: 'write',
                    format(tagOpen, tagClose = '') {
                        const textarea = this.$refs.textarea;
                        const start = textarea.selectionStart;
                        const end = textarea.selectionEnd;
                        const text = textarea.value;
                        const selected = text.substring(start, end);
                        const replacement = tagOpen + (selected || '') + tagClose;
                        textarea.value = text.substring(0, start) + replacement + text.substring(end);
                        textarea.focus();
                        textarea.setSelectionRange(start + tagOpen.length, start + tagOpen.length + (selected ? selected.length : 0));
                        textarea.dispatchEvent(new Event('input', { bubbles: true }));
                    },
                    insertList(ordered = false) {
                        const textarea = this.$refs.textarea;
                        const start = textarea.selectionStart;
                        const end = textarea.selectionEnd;
                        const text = textarea.value;
                        const tag = ordered ? 'ol' : 'ul';
                        const listHtml = `<${tag}>\n  <li>Elemento 1</li>\n  <li>Elemento 2</li>\n</${tag}>\n`;
                        textarea.value = text.substring(0, start) + listHtml + text.substring(end);
                        textarea.focus();
                        textarea.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }">
                    <div class="flex items-center justify-between mb-1">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">
                            {{ __('actividades.description') }}
                        </label>
                        <!-- Selector Modo Editor / Vista Previa -->
                        <div class="flex rounded-lg bg-gray-100 p-0.5 text-xs">
                            <button type="button" @click="tab = 'write'"
                                :class="tab === 'write' ? 'bg-white text-gray-900 shadow-xs font-semibold' : 'text-gray-500 hover:text-gray-800'"
                                class="px-2.5 py-1 rounded-md transition flex items-center gap-1">
                                <span>✏️</span>
                                <span>{{ __('Editor') }}</span>
                            </button>
                            <button type="button" @click="tab = 'preview'"
                                :class="tab === 'preview' ? 'bg-white text-gray-900 shadow-xs font-semibold' : 'text-gray-500 hover:text-gray-800'"
                                class="px-2.5 py-1 rounded-md transition flex items-center gap-1">
                                <span>👁️</span>
                                <span>{{ __('Vista previa') }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Barra de herramientas de formato HTML -->
                    <div x-show="tab === 'write'" class="flex flex-wrap items-center gap-1 p-1.5 bg-gray-50 border border-gray-300 rounded-t-lg border-b-0 text-xs">
                        <button type="button" @click="format('<strong>', '</strong>')" title="{{ __('Negrita') }}"
                            class="px-2.5 py-1 rounded bg-white hover:bg-gray-100 border border-gray-200 font-bold text-gray-800 shadow-2xs">
                            B
                        </button>
                        <button type="button" @click="format('<em>', '</em>')" title="{{ __('Cursiva') }}"
                            class="px-2.5 py-1 rounded bg-white hover:bg-gray-100 border border-gray-200 italic font-serif text-gray-800 shadow-2xs">
                            I
                        </button>
                        <button type="button" @click="format('<u>', '</u>')" title="{{ __('Subrayado') }}"
                            class="px-2.5 py-1 rounded bg-white hover:bg-gray-100 border border-gray-200 underline text-gray-800 shadow-2xs">
                            U
                        </button>
                        <span class="w-px h-4 bg-gray-300 mx-1"></span>
                        <button type="button" @click="insertList(false)" title="{{ __('Lista con viñetas') }}"
                            class="px-2.5 py-1 rounded bg-white hover:bg-gray-100 border border-gray-200 text-gray-800 shadow-2xs flex items-center gap-1">
                            <span>•</span> <span>{{ __('Lista') }}</span>
                        </button>
                        <button type="button" @click="insertList(true)" title="{{ __('Lista numerada') }}"
                            class="px-2.5 py-1 rounded bg-white hover:bg-gray-100 border border-gray-200 text-gray-800 shadow-2xs flex items-center gap-1">
                            <span>1.</span> <span>{{ __('Numerada') }}</span>
                        </button>
                        <span class="w-px h-4 bg-gray-300 mx-1"></span>
                        <button type="button" @click="format('<p>', '</p>')" title="{{ __('Párrafo') }}"
                            class="px-2.5 py-1 rounded bg-white hover:bg-gray-100 border border-gray-200 text-gray-800 shadow-2xs">
                            ¶ {{ __('Párrafo') }}
                        </button>
                        <button type="button" @click="format('<br>')" title="{{ __('Salto de línea') }}"
                            class="px-2.5 py-1 rounded bg-white hover:bg-gray-100 border border-gray-200 text-gray-800 shadow-2xs">
                            ↵ {{ __('Salto') }}
                        </button>
                    </div>

                    <!-- Textarea con wire:model -->
                    <div x-show="tab === 'write'">
                        <textarea x-ref="textarea" id="descripcion" rows="5" wire:model="descripcion"
                            placeholder="Detalles del evento, horarios, menú o itinerario. Puedes escribir texto o etiquetas HTML como <strong>negrita</strong> o <ul><li>listas</li></ul>..."
                            class="w-full rounded-b-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm font-sans"></textarea>
                    </div>

                    <!-- Pestaña de Vista Previa -->
                    <div x-show="tab === 'preview'" class="p-4 rounded-lg border border-gray-300 bg-gray-50/50 min-h-[9rem]">
                        <template x-if="$wire.descripcion">
                            <div class="prose prose-sm max-w-none text-gray-700 bg-white p-4 rounded-lg border border-gray-100 shadow-2xs"
                                x-html="$wire.descripcion"></div>
                        </template>
                        <template x-if="!$wire.descripcion">
                            <p class="text-xs text-gray-400 italic text-center py-4">{{ __('Sin descripción') }}</p>
                        </template>
                    </div>

                    <p class="text-[11px] text-gray-400 mt-1">
                        {{ __('Admite formato HTML: puedes usar los botones de la barra para insertar negritas, listas o párrafos, o escribir tus propias etiquetas.') }}
                    </p>
                    @error('descripcion') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Instrucciones de Pago (Solo si es de pago) -->
                @if ($es_de_pago)
                    <div class="md:col-span-2">
                        <label for="instrucciones_pago" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('actividades.payment_instructions') }}
                        </label>
                        <textarea id="instrucciones_pago" rows="2" wire:model="instrucciones_pago"
                            placeholder="Ex. Realitzar Bizum al 600123456 amb concepte 'Sopar + Nom'..."
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm"></textarea>
                        @error('instrucciones_pago') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                @endif
            </div>
        </div>

        @if ($es_de_pago)
            <!-- Tarjeta de Opciones / Menús / Precios -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <span>🏷️</span> {{ __('actividades.options_available') }}
                        </h2>
                        <p class="text-xs text-gray-500">{{ __('actividades.options_available_sub') }}</p>
                    </div>
                    <button type="button" wire:click="addOpcion"
                        class="inline-flex items-center rounded-lg bg-cyan-50 border border-cyan-200 px-3 py-1.5 text-xs font-semibold text-cyan-700 hover:bg-cyan-100 transition">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        {{ __('actividades.add_option') }}
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach ($opciones as $index => $opcion)
                        <div wire:key="opcion-row-{{ $index }}" class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-3 relative">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-cyan-700">
                                    {{ __('Opció') }} #{{ $index + 1 }}
                                </span>
                                @if (count($opciones) > 1)
                                    <button type="button" wire:click="removeOpcion({{ $index }})"
                                        class="text-rose-500 hover:text-rose-700 text-xs font-medium inline-flex items-center gap-1 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        {{ __('actividades.delete_option') }}
                                    </button>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                                <div class="sm:col-span-8">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">{{ __('actividades.option_title') }} <span class="text-rose-500">*</span></label>
                                    <input type="text" wire:model="opciones.{{ $index }}.titulo" placeholder="Ex. Menú Carn, Menú Peix, Menú Infantil..."
                                        class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" />
                                    @error("opciones.{$index}.titulo") <span class="text-xs text-rose-600 block mt-0.5">{{ $message }}</span> @enderror
                                </div>

                                <div class="sm:col-span-4">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">{{ __('actividades.option_price') }} <span class="text-rose-500">*</span></label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <input type="number" step="0.01" min="0" wire:model="opciones.{{ $index }}.precio" placeholder="0.00"
                                            class="w-full rounded-lg border-gray-300 text-sm pr-8 focus:border-cyan-500 focus:ring-cyan-500" />
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 text-xs">€</span>
                                        </div>
                                    </div>
                                    @error("opciones.{$index}.precio") <span class="text-xs text-rose-600 block mt-0.5">{{ $message }}</span> @enderror
                                </div>

                                <div class="sm:col-span-12">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">{{ __('actividades.option_description') }}</label>
                                    <input type="text" wire:model="opciones.{{ $index }}.descripcion" placeholder="Ex. Entrants al centre, plat principal, postre i beguda..."
                                        class="w-full rounded-lg border-gray-300 text-xs shadow-sm focus:border-cyan-500 focus:ring-cyan-500" />
                                    @error("opciones.{$index}.descripcion") <span class="text-xs text-rose-600 block mt-0.5">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('opciones')
                    <span class="text-xs text-rose-600 block">{{ $message }}</span>
                @enderror
            </div>
        @else
            <!-- Tarjeta Informativa de Modalidad Individual sin Precio -->
            <div class="rounded-2xl bg-cyan-50/60 p-6 shadow-sm border border-cyan-200 space-y-2">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🎺</span>
                    <h2 class="text-base font-bold text-cyan-950">{{ __('actividades.modality_free_title') }}</h2>
                </div>
                <p class="text-xs text-cyan-900 leading-relaxed">
                    {{ __('actividades.attendance_confirmation_desc') }}
                </p>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/80 border border-cyan-300 text-xs text-cyan-800 font-semibold mt-1">
                    <span>✓ {{ __('actividades.btn_confirm_attendance') }} (Sí)</span>
                    <span>/</span>
                    <span>✗ {{ __('actividades.btn_not_attending') }} (No)</span>
                </div>
            </div>
        @endif

        <!-- Botones de Acción -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.actividades.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                {{ __('actividades.cancel') }}
            </a>
            <button type="submit"
                class="rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-cyan-500 transition shadow-sm inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ $isEditing ? __('actividades.save_changes') : __('actividades.create_and_publish') }}
            </button>
        </div>
    </form>
</div>
