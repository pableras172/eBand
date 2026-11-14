<div>
    @if ($showModal && $announcement)
        <div x-data="{ open: true }" 
             x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[60] flex items-end justify-center bg-black/50 p-4 sm:items-center">
            <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl relative"
                 @click.away="open = false; $wire.dismiss()">
                <div class="bg-gradient-to-r from-cyan-600 to-teal-600 px-5 py-4 text-white flex items-center justify-between">                    
                    <h3 class="mt-1 text-xl font-bold leading-tight">{{ $announcement->title }}</h3>
                    <button type="button" 
                            @click="open = false; $wire.dismiss()" 
                            class="text-white/80 hover:text-white transition p-1 rounded-lg hover:bg-white/10"
                            aria-label="{{ __('Tancar') }}">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <div class="max-h-[65vh] overflow-y-auto px-5 py-5">
                    @if ($hasCustomView)
                        @include($announcement->content_view)
                    @else
                        <div class="prose prose-sm max-w-none text-gray-700">
                            {!! (string) $announcement->body !!}
                        </div>
                    @endif
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end">                   
                    <button type="button" 
                        @click="open = false; $wire.markAsRead()"
                        wire:click="markAsRead"
                        class="inline-flex justify-center rounded-xl bg-cyan-600 px-5 py-2 text-sm font-semibold text-white hover:bg-cyan-500 active:scale-95 transition shadow-sm">
                        {{ __('Ok') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
