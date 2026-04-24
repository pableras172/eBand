<div>
    @if ($showModal && $announcement)
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/50 p-4 sm:items-center">
            <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
                <div class="bg-gradient-to-r from-cyan-600 to-teal-600 px-5 py-4 text-white">                    
                    <h3 class="mt-1 text-xl font-bold leading-tight">{{ $announcement->title }}</h3>
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
                    <button type="button" wire:click="markAsRead"
                        class="inline-flex justify-center rounded-md bg-cyan-600 px-4 py-2 text-sm font-semibold text-white hover:bg-cyan-500">
                        {{ __('Ok') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
