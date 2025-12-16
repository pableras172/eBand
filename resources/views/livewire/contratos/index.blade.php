<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Llistat de contrats') }}
        </h2>
    </x-slot>

    {{-- creado --}}
    @if (session()->has('success'))
        <div class="flash-alert bg-green-200 text-green-800 py-2 px-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- eliminado --}}
    @if (session()->has('deletesuccess'))
        <div class="flash-alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
            role="alert">
            <strong class="font-bold">{{ __('Contracte eliminat') }}</strong>
            <span class="block sm:inline">{{ session('deletesuccess') }}</span>
        </div>
    @endif

    {{-- duplicado --}}
    @if (session()->has('duplicatesuccess'))
        <div class="flash-alert transition-opacity duration-700 ease-out bg-green-200 text-green-800 py-2 px-4 mb-4 rounded">
            {{ session('duplicatesuccess') }}
        </div>
    @endif

    <div class="container mx-auto py-2 px-2 sm:px-6 lg:px-0">
        <div class="block mb-2 flex justify-end">
            <select id="yearSelect"
                class="appearance-none bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                @for ($i = date('Y') - 3; $i <= date('Y') + 2; $i++)
                    <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider  md:table-cell">
                                        {{ __('Població') }}
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Descripció') }}
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{ __('Data Inici') }}
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{ __('Data de Fi') }}
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{ __('Contacte') }}
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Accions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($contratos as $contrato)
                                    <tr>
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900">
                                            {{ $contrato->poblacion }}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900  md:table-cell">
                                            {{ $contrato->descripcion }}
                                        </td>
                                        <td
                                            class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $contrato->fechainicio ? \Carbon\Carbon::parse($contrato->fechainicio)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td
                                            class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $contrato->fechafin ? \Carbon\Carbon::parse($contrato->fechafin)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td
                                            class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $contrato->contacto }}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2">
                                                <a href="{{ route('contratos.edit', $contrato->id) }}" class="">
                                                    <x-editar w="24" h="24" />
                                                </a>
                                                &nbsp;
                                                <a href="{{ route('actuacion.createtocontract', $contrato->id) }}"
                                                    class="">
                                                    <x-calendario w="24" h="24" />
                                                </a>
                                                <a href="{{ route('contratos.duplicate', $contrato->id) }}">
                                                    <x-duplicar w="24" h="24" />
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $contratos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('yearSelect').addEventListener('change', function() {
            var year = this.value;
            window.location.href = "/contratos/year/" + year;
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
        });
    </script>

    <footer
        class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow-t-md dark:bg-gray-800 dark:border-gray-600">
        <div class="flex justify-center items-center py-3">
            <!-- Botón Nou Contracte -->
            <a href="{{ route('contratos.create') }}"
                class="flex flex-col items-center text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 transition">
                <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                        <title>ic_fluent_apps_add_in_24_regular</title>
                        <desc>Created with Sketch.</desc>
                        <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="ic_fluent_apps_add_in_24_regular" fill="#0c6600" fill-rule="nonzero">
                                <path
                                    d="M10.5,3 C11.7426407,3 12.75,4.00735931 12.75,5.25 L12.75,11.25 L18.75,11.25 C19.9926407,11.25 21,12.2573593 21,13.5 L21,18.75 C21,19.9926407 19.9926407,21 18.75,21 L5.25,21 C4.00735931,21 3,19.9926407 3,18.75 L3,5.25 C3,4.00735931 4.00735931,3 5.25,3 L10.5,3 Z M11.25,12.75 L4.5,12.75 L4.5,18.75 C4.5,19.1642136 4.83578644,19.5 5.25,19.5 L11.249,19.5 L11.25,12.75 Z M18.75,12.75 L12.749,12.75 L12.749,19.5 L18.75,19.5 C19.1642136,19.5 19.5,19.1642136 19.5,18.75 L19.5,13.5 C19.5,13.0857864 19.1642136,12.75 18.75,12.75 Z M10.5,4.5 L5.25,4.5 C4.83578644,4.5 4.5,4.83578644 4.5,5.25 L4.5,11.25 L11.25,11.25 L11.25,5.25 C11.25,4.83578644 10.9142136,4.5 10.5,4.5 Z M17.8982294,2.00684662 L18,2 C18.3796958,2 18.693491,2.28215388 18.7431534,2.64822944 L18.75,2.75 L18.75,5.25 L21.25,5.25 C21.6296958,5.25 21.943491,5.53215388 21.9931534,5.89822944 L22,6 C22,6.37969577 21.7178461,6.69349096 21.3517706,6.74315338 L21.25,6.75 L18.75,6.75 L18.75,9.25 C18.75,9.62969577 18.4678461,9.94349096 18.1017706,9.99315338 L18,10 C17.6203042,10 17.306509,9.71784612 17.2568466,9.35177056 L17.25,9.25 L17.25,6.75 L14.75,6.75 C14.3703042,6.75 14.056509,6.46784612 14.0068466,6.10177056 L14,6 C14,5.62030423 14.2821539,5.30650904 14.6482294,5.25684662 L14.75,5.25 L17.25,5.25 L17.25,2.75 C17.25,2.37030423 17.5321539,2.05650904 17.8982294,2.00684662 Z"
                                    id="🎨-Color"> </path>
                            </g>
                        </g>
                    </g>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Nou contracte') }}</span>
            </a>
        </div>
    </footer>

</x-app-layout>
