<x-action-section>
    <x-slot name="title">
        <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-2.5 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ __('Estadístiques') }}</h3>
                    <div class="h-1 w-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full mt-1"></div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="description">
        <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 space-y-2">
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                {{ __('Visualiza les estadístiques de participació en actuacions.') }}
            </p>
            <div class="flex items-start space-x-2 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-3">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <p class="text-xs text-indigo-700 dark:text-indigo-300">
                    {{ __('Consulta la teua activitat i rendiment al llarg dels anys.') }}
                </p>
            </div>
        </div>
    </x-slot>
    
    <x-slot name="content">
        <x-usermetrics :userId="Auth::user()->id" />
    </x-slot>
</x-action-section>