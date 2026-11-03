@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-2.5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div class="px-4 py-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 {{ isset($actions) ? 'rounded-t-lg sm:rounded-tl-lg sm:rounded-tr-lg' : 'rounded-lg' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:px-6 shadow-sm border-x border-b border-gray-200 dark:border-gray-700 rounded-b-lg">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
