<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('crud.suggestions.collectionTitle') }}
        </h2>
    </x-slot>

    <div class="flex justify-between align-top py-1">
        <x-ui.input wire:model.live="search" type="text"
            placeholder="Search {{ __('crud.suggestions.collectionTitle') }}..." />
    </div>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('Are you sure?') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger class="ml-3" wire:click="delete({{ $deletingSuggestion }})"
                wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-ui.button.danger>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- Index Table --}}
    <x-ui.container.table>
        <x-ui.table>
            <x-slot name="head">
                <x-ui.table.header for-crud
                    wire:click="sortBy('fechacreacion')">{{ __('crud.suggestions.inputs.fechacreacion.label') }}</x-ui.table.header>
                <x-ui.table.header for-crud
                    wire:click="sortBy('titulo')">{{ __('crud.suggestions.inputs.titulo.label') }}</x-ui.table.header>

                <x-ui.table.header for-crud
                    wire:click="sortBy('iduser')">{{ __('crud.suggestions.inputs.iduser.label') }}</x-ui.table.header>
                <x-ui.table.action-header>Actions</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($suggestions as $suggestion)
                    <x-ui.table.row wire:loading.class.delay="opacity-75">
                        <x-ui.table.column
                            for-crud>{{ $suggestion->fechacreacion ? \Carbon\Carbon::parse($suggestion->fechacreacion)->format('d/m/Y') : '' }}</x-ui.table.column>
                        <x-ui.table.column for-crud>{{ $suggestion->titulo }}</x-ui.table.column>

                        <x-ui.table.column for-crud>
                            @if($suggestion->anonimo==false)
                                {{ $suggestion->user->name ?? $suggestion->user->email }}
                            @else
                                {{ __('crud.suggestions.anonymous') ?: 'Anónimo' }}
                            @endif
                        </x-ui.table.column>
                        <x-ui.table.action-column>
                            @can('update', $suggestion)
                                <div class="flex justify-center items-center space-x-2">
                                    <x-ui.action wire:navigate
                                        href="{{ route('suggestions.edit', $suggestion) }}"><x-editar w="18"
                                            h="18" /></x-ui.action>
                                    @endcan @can('delete', $suggestion)
                                    <x-ui.action.danger wire:click="confirmDeletion({{ $suggestion->id }})"> <x-delete
                                            w="18" h="18" /></x-ui.action.danger>
                                </div>
                            @endcan
                        </x-ui.table.action-column>
                    </x-ui.table.row>
                @empty
                    <x-ui.table.row>
                        <x-ui.table.column colspan="6">{{ __('crud.suggestions.collectionTitle') }}
                        </x-ui.table.column>
                    </x-ui.table.row>
                @endforelse
            </x-slot>            
        </x-ui.table>        
    </x-ui.container.table>
    <div style="display: block; margin-bottom:100px" class="mt-5 mb-100">{{ $suggestions->links() }}</div>
    <footer
        class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow-t-md dark:bg-gray-800 dark:border-gray-600">
        <div class="flex justify-center items-center py-3">
            <!-- Botón Nou Contracte -->
            <a href="{{ route('suggestions.create') }}"
                class="flex flex-col items-center text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 transition">
                <svg height="64px" width="64px" version="1.1" id="_x35_" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                    fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <g>
                                <g>
                                    <circle style="fill:#FDF4DE;" cx="255.693" cy="134.136" r="134.136"></circle>
                                    <path style="fill:#EFE0AD;"
                                        d="M257.535,79.113H182.64c-6.078,0-11.05-4.973-11.05-11.05l0,0c0-6.077,4.973-11.05,11.05-11.05 h74.895c6.078,0,11.05,4.973,11.05,11.05l0,0C268.585,74.14,263.612,79.113,257.535,79.113z">
                                    </path>
                                    <path style="fill:#EFE0AD;"
                                        d="M244.643,126.076h-74.895c-6.077,0-11.05-4.973-11.05-11.05l0,0c0-6.077,4.973-11.05,11.05-11.05 h74.895c6.077,0,11.05,4.973,11.05,11.05l0,0C255.693,121.103,250.72,126.076,244.643,126.076z">
                                    </path>
                                    <path style="fill:#EFE0AD;"
                                        d="M351.461,176.722H169.748c-6.077,0-11.05-4.973-11.05-11.05l0,0c0-6.078,4.973-11.05,11.05-11.05 h181.713c6.077,0,11.05,4.973,11.05,11.05l0,0C362.511,171.749,357.538,176.722,351.461,176.722z">
                                    </path>
                                    <path style="fill:#EFE0AD;"
                                        d="M270.887,212.635h-86.866c-6.078,0-11.05-4.973-11.05-11.05l0,0c0-6.078,4.973-11.05,11.05-11.05 h86.866c6.078,0,11.05,4.973,11.05,11.05l0,0C281.937,207.662,276.965,212.635,270.887,212.635z">
                                    </path>
                                    <path style="fill:#EFE0AD;"
                                        d="M349.619,126.076h-74.895c-6.078,0-11.05-4.973-11.05-11.05l0,0c0-6.077,4.972-11.05,11.05-11.05 h74.895c6.077,0,11.05,4.973,11.05,11.05l0,0C360.669,121.103,355.696,126.076,349.619,126.076z">
                                    </path>
                                    <polygon style="fill:#FDF4DE;"
                                        points="209.185,252.621 282.019,241.572 284.185,311.096 "></polygon>
                                </g>
                                <path style="fill:#EFE0AD;"
                                    d="M186.636,272.351c-14.07,14.07-31.953,24.347-51.991,29.117l-48.584,37.883l1.16-37.11 C37.441,292.039,0,247.986,0,195.203C0,134.851,48.933,85.918,109.285,85.918h0.055c-4.199,14.328-6.446,29.485-6.446,45.177 C102.895,191.999,136.727,245.021,186.636,272.351z">
                                </path>
                                <path style="fill:#EFE0AD;"
                                    d="M325.364,272.351c14.07,14.07,31.953,24.347,51.991,29.117l48.584,37.883l-1.16-37.11 C474.559,292.039,512,247.986,512,195.203c0-60.352-48.934-109.285-109.285-109.285h-0.055 c4.199,14.328,6.446,29.485,6.446,45.177C409.105,191.999,375.273,245.021,325.364,272.351z">
                                </path>
                            </g>
                            <g style="opacity:0.04;">
                                <path style="fill:#070405;"
                                    d="M389.829,134.136c0-27.879-8.515-53.763-23.072-75.216L180.623,245.053 c13.122,8.877,27.842,15.574,43.714,19.382l59.847,46.661l-1.419-45.56C343.869,253.013,389.829,198.943,389.829,134.136z">
                                </path>
                                <path style="fill:#070405;"
                                    d="M87.256,338.42l47.389-36.952c20.037-4.77,37.92-15.046,51.991-29.117 c-7.07-3.871-13.774-8.311-20.148-13.163L87.256,338.42z">
                                </path>
                                <path style="fill:#070405;"
                                    d="M512,195.203c0-60.352-48.934-109.286-109.286-109.286h-0.055 c4.199,14.328,6.446,29.485,6.446,45.177c0,60.904-33.832,113.926-83.741,141.257c14.07,14.07,31.953,24.347,51.991,29.117 l48.584,37.884l-1.16-37.11C474.559,292.039,512,247.986,512,195.203z">
                                </path>
                            </g>
                        </g>
                    </g>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Nou sugeriment') }}</span>
            </a>
        </div>
    </footer>
</div>
