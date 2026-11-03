<div class="md:col-span-1 flex justify-between w-full">
    <div class="w-full flex-1 px-4 sm:px-0 space-y-2">
        <div class="w-full text-lg font-medium text-gray-900 dark:text-gray-100">{{ $title }}</div>

        <div class="w-full text-sm text-gray-600 dark:text-gray-400">
            {{ $description }}
        </div>
    </div>

    @if (isset($aside) && filled((string) $aside))
        <div class="px-4 sm:px-0">
            {{ $aside }}
        </div>
    @endif
</div>
