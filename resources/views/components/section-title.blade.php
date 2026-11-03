<div class="md:col-span-1 flex justify-between w-full">
    <div class="w-full flex-1 space-y-2">
        <div class="w-full text-lg font-medium text-gray-900 dark:text-gray-100">{{ $title }}</div>

        <div class="w-full text-sm text-gray-600 dark:text-gray-400">
            {{ $description }}
        </div>
    </div>

    @if (isset($aside) && filled((string) $aside))
        <div>
            {{ $aside }}
        </div>
    @endif
</div>
