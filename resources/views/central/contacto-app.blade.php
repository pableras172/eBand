<x-guest-layout>
    <section class="min-h-screen bg-slate-50 px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-xl">
            <div class="mb-6 flex flex-col items-center text-center">
                <img src="{{ asset('logo_e_band.png') }}" alt="eBand" class="h-14 w-auto mb-3">
                <span class="inline-block rounded-full bg-blue-100 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-blue-800">
                    {{ __('Contacto') }}
                </span>
                <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                    {{ __('¿Quieres llevar eBand a tu agrupación?') }}
                </h1>
                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                    {{ __('Cuéntanos brevemente cómo os organizáis y te contactaremos con toda la información para vuestra banda, charanga o coral.') }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/50 sm:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                        <div class="flex items-center gap-2 font-bold">
                            <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ __('¡Mensaje recibido con éxito!') }}</span>
                        </div>
                        <p class="mt-1 text-xs text-emerald-700">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="nombre" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                {{ __('Tu Nombre *') }}
                            </label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                                   placeholder="Ej: Laura Martínez"
                                   class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                            @error('nombre')
                                <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="banda" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                {{ __('Nombre de la Agrupación *') }}
                            </label>
                            <input type="text" id="banda" name="banda" value="{{ old('banda') }}" required
                                   placeholder="Banda, Charanga o Coral..."
                                   class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                            @error('banda')
                                <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                {{ __('Correo Electrónico *') }}
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="directiva@tubanda.es"
                                   class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                            @error('email')
                                <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="telefono" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                {{ __('Teléfono (opcional)') }}
                            </label>
                            <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}"
                                   placeholder="+34 600 000 000"
                                   class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                            @error('telefono')
                                <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="informacion" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            {{ __('¿Qué os gustaría organizar o mejorar? *') }}
                        </label>
                        <textarea id="informacion" name="informacion" rows="4" required
                                  placeholder="Cuéntanos cuántos integrantes sois, cómo gestionáis ahora los ensayos o cualquier duda que tengáis..."
                                  class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">{{ old('informacion') }}</textarea>
                        @error('informacion')
                            <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="pt-2">
                        {!! NoCaptcha::display() !!}
                        @error('g-recaptcha-response')
                            <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full rounded-xl bg-gradient-to-r from-blue-700 to-indigo-600 py-3.5 text-center text-sm font-bold text-white shadow-md shadow-blue-700/20 transition hover:from-blue-800 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        {{ __('Enviar Consulta') }}
                    </button>

                    <p class="text-[11px] text-center text-slate-500">
                        {{ __('Respetamos tu privacidad. Tus datos solo se utilizarán para responder a esta solicitud. Consulta nuestra') }}
                        <a href="{{ route('politica-privacidad') }}" class="underline hover:text-blue-700">{{ __('Política de Privacidad') }}</a>.
                    </p>
                </form>
            </div>
        </div>
    </section>

    {!! NoCaptcha::renderJs() !!}
</x-guest-layout>
