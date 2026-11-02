@php
    $mensajes = App\Models\Comment::with('user', 'actuacion')
        ->whereHas('actuacion', function ($query) {
            $query->where('fechaActuacion', '>=', now());
        })
        ->get();
@endphp


<div class="bg-white p-3 sm:p-4">
    {{-- Contenedor del encabezado con contador --}}
    <div class="flex justify-between items-center mb-3">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7 mr-2 text-blue-600 animate-bounce" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
            <h1 class="text-lg sm:text-xl font-bold text-gray-800">
                {{__('Ultimos mensajes')}}
            </h1>
        </div>
        @if ($mensajes->isNotEmpty())
            <span class="text-xs sm:text-sm text-gray-500 bg-gray-100 px-2 sm:px-3 py-1 rounded-full whitespace-nowrap">
                <span id="current-message">1</span> / {{ $mensajes->count() }}
            </span>
        @endif
    </div>
   
    @if ($mensajes->isNotEmpty())
        @php
            $mensaje = $mensajes->first();
        @endphp

        <div class="relative">
            {{-- Botones de navegación --}}
            @if ($mensajes->count() > 1)
                <button id="prev-btn" 
                    class="absolute -left-1 sm:left-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 hover:bg-white rounded-full p-1.5 sm:p-2 shadow-lg transition-all hover:scale-110 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    aria-label="{{ __('Anterior') }}">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                
                <button id="next-btn"
                    class="absolute -right-1 sm:right-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 hover:bg-white rounded-full p-1.5 sm:p-2 shadow-lg transition-all hover:scale-110 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    aria-label="{{ __('Següent') }}">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @endif

            <div id="message-container" class="transition-opacity duration-300 px-2 sm:px-0">
                <div class="relative grid grid-cols-1 gap-3 sm:gap-4 p-3 sm:p-4 mt-2 mb-1 border rounded-lg bg-white shadow-lg">
                    <div class="relative flex flex-col sm:flex-row gap-3 sm:gap-4">
                        {{-- Contenedor del Avatar --}}
                        <div class="relative w-16 h-16 sm:w-20 sm:h-20 mx-auto sm:mx-0 aspect-square flex-shrink-0">
                            <img id="carousel-avatar" class="w-full h-full rounded-full object-cover border-3 sm:border-4 border-blue-500"
                                src="{{ $mensaje->user->profile_photo_url }}" alt="{{ $mensaje->user->name }}" />

                            {{-- Badge con icono del instrumento --}}
                            <div
                                class="absolute bottom-0 right-0 w-5 h-5 sm:w-6 sm:h-6 bg-white rounded-full border-2 border-blue-500 flex items-center justify-center">
                                @if(isset($mensaje->user->instrument) && !empty($mensaje->user->instrument->icon))
                                    <img id="carousel-instrument" src="{{ asset('storage/imagenes/instruments/' . $mensaje->user->instrument->icon) }}"
                                        alt="{{ $mensaje->user->instrument->name ?? '' }}" class="w-3 h-3 sm:w-4 sm:h-4">
                                @else
                                    <span class="text-[10px] font-bold text-blue-600">🎵</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col w-full">
                            <div class="flex flex-row justify-between items-center gap-2">
                                {{-- Nombre del usuario --}}
                                <p id="carousel-user" class="relative text-base sm:text-lg whitespace-nowrap truncate overflow-hidden font-semibold text-gray-800">
                                    {{ $mensaje->user->name }}
                                </p>
                                <p id="carousel-date" class="text-gray-400 text-xs sm:text-sm whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($mensaje->created_at)->format('d/m/Y') }}
                                </p>
                            </div>
                            <hr class="my-2">
                            <div class="mt-1 sm:mt-2">
                                {{-- Contenido del comentario --}}
                                <p id="carousel-message" class="text-sm sm:text-base text-gray-600 leading-relaxed">
                                    {{ $mensaje->comment }}
                                </p>
                            </div>
                            <hr class="my-2">
                            <div class="mt-1 sm:mt-2 flex justify-between items-center gap-2">
                                <p id="actuacionName" class="text-xs sm:text-sm text-gray-700 font-medium truncate flex-1 min-w-0">{{ $mensaje->actuacion->descripcion }}</p>    
                                <a id="enlaceActuacion" href="{{ route('listas.actuacion', ['actuacion_id' =>  $mensaje->actuacion->id]) }}"
                                    class="flex-shrink-0 hover:scale-110 transition-transform"
                                    aria-label="{{ __('Veure actuació') }}">
                                    <svg width="24px" height="24px" class="sm:w-7 sm:h-7" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                        <g stroke-width="0"></g>
                                        <g stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g fill="#b06d36" fill-rule="nonzero">
                                                    <path d="M14.6470979,6.30372605 L14.7197247,6.21961512 C14.9860188,5.95337607 15.402685,5.92921307 15.6962739,6.14709787 L15.7803849,6.21972471 L20.7769976,11.21737 C21.0430885,11.4835159 21.0673924,11.8999028 20.8498298,12.1934928 L20.777305,12.2776129 L15.7806923,17.2810585 C15.4879993,17.5741518 15.0131257,17.5744763 14.7200324,17.2817833 C14.453584,17.0156987 14.4290932,16.5990517 14.646747,16.3052914 L14.7193077,16.2211234 L18.4301989,12.504 L3.75019891,12.504946 C3.37050315,12.504946 3.05670795,12.2227922 3.00704553,11.8567166 L3.00019891,11.754946 C3.00019891,11.3752503 3.28235279,11.0614551 3.64842835,11.0117927 L3.75019891,11.004946 L18.4431989,11.004 L14.7196151,7.28027529 C14.4533761,7.01398122 14.4292131,6.59731504 14.6470979,6.30372605 L14.7197247,6.21961512 L14.6470979,6.30372605 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </a>                       
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Indicadores de posición (dots) --}}
            @if ($mensajes->count() > 1)
                <div class="flex justify-center gap-2 mt-3">
                    @foreach ($mensajes as $index => $m)
                        <button class="carousel-dot w-2 h-2 rounded-full transition-all {{ $index === 0 ? 'bg-blue-600 w-6' : 'bg-gray-300 hover:bg-gray-400' }}"
                            data-index="{{ $index }}"
                            aria-label="{{ __('Anar al missatge') }} {{ $index + 1 }}">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p class="text-gray-500">{{__('No hay mensajes recientes')}}</p>
        </div>
    @endif   
</div>
@php
    $formattedMessages = $mensajes->map(function ($mensaje) {
        return [
            'user' => $mensaje->user->name,
            'comment' => $mensaje->comment,
            'date' => \Carbon\Carbon::parse($mensaje->created_at)->format('d/m/Y'),
            'photo' => $mensaje->user->profile_photo_url ?? 'https://icons.iconarchive.com/icons/diversity-avatars/avatars/256/charlie-chaplin-icon.png',
            'instrument' => $mensaje->user->instrument ? '/storage/imagenes/instruments/' . $mensaje->user->instrument->icon : '/storage/imagenes/instruments/default.png',
            'actuacionName' => $mensaje->actuacion->descripcion,
            'enlaceActuacion' => route('listas.actuacion', ['actuacion_id' => $mensaje->actuacion->id]),
        ];
    });
@endphp
{{-- JavaScript para controlar el carrusel con botones y gestos táctiles --}}
<script type="module">
    document.addEventListener("DOMContentLoaded", function() {
        const messages = @json($formattedMessages);

        let currentIndex = 0;
        let autoScrollInterval;
        let isPaused = false;

        const messageElement = document.getElementById("carousel-message");
        const nameElement = document.getElementById("carousel-user");
        const dateElement = document.getElementById("carousel-date");
        const avatarElement = document.getElementById("carousel-avatar");
        const instrumentElement = document.getElementById("carousel-instrument");
        const actuacionName = document.getElementById("actuacionName");
        const enlaceActuacion = document.getElementById("enlaceActuacion");
        const messageContainer = document.getElementById("message-container");
        const currentMessageCounter = document.getElementById("current-message");
        const prevBtn = document.getElementById("prev-btn");
        const nextBtn = document.getElementById("next-btn");
        const dots = document.querySelectorAll(".carousel-dot");

        function updateMessage(index, animate = true) {
            if (messages.length === 0) return;

            if (animate) {
                messageContainer.style.opacity = "0";
                setTimeout(() => {
                    applyMessageData(index);
                    messageContainer.style.opacity = "1";
                }, 150);
            } else {
                applyMessageData(index);
            }
        }

        function applyMessageData(index) {
            const msg = messages[index];
            nameElement.textContent = msg.user;
            messageElement.textContent = msg.comment;
            dateElement.textContent = msg.date;
            avatarElement.src = msg.photo;
            instrumentElement.src = msg.instrument;
            actuacionName.textContent = msg.actuacionName;
            enlaceActuacion.href = msg.enlaceActuacion;
            
            // Actualizar contador
            if (currentMessageCounter) {
                currentMessageCounter.textContent = index + 1;
            }
            
            // Actualizar dots
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.remove("bg-gray-300", "w-2");
                    dot.classList.add("bg-blue-600", "w-6");
                } else {
                    dot.classList.remove("bg-blue-600", "w-6");
                    dot.classList.add("bg-gray-300", "w-2");
                }
            });
        }

        function nextMessage() {
            currentIndex = (currentIndex + 1) % messages.length;
            updateMessage(currentIndex);
        }

        function prevMessage() {
            currentIndex = (currentIndex - 1 + messages.length) % messages.length;
            updateMessage(currentIndex);
        }

        function goToMessage(index) {
            currentIndex = index;
            updateMessage(currentIndex);
        }

        function startAutoScroll() {
            if (messages.length > 1) {
                autoScrollInterval = setInterval(() => {
                    if (!isPaused) {
                        nextMessage();
                    }
                }, 5000);
            }
        }

        function stopAutoScroll() {
            clearInterval(autoScrollInterval);
        }

        function pauseAutoScroll() {
            isPaused = true;
        }

        function resumeAutoScroll() {
            isPaused = false;
        }

        // Event listeners para botones de navegación
        if (prevBtn) {
            prevBtn.addEventListener("click", () => {
                prevMessage();
                stopAutoScroll();
                startAutoScroll();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener("click", () => {
                nextMessage();
                stopAutoScroll();
                startAutoScroll();
            });
        }

        // Event listeners para dots
        dots.forEach((dot, index) => {
            dot.addEventListener("click", () => {
                goToMessage(index);
                stopAutoScroll();
                startAutoScroll();
            });
        });

        // Pausar auto-scroll al hacer hover en el mensaje
        if (messageContainer) {
            messageContainer.addEventListener("mouseenter", pauseAutoScroll);
            messageContainer.addEventListener("mouseleave", resumeAutoScroll);
        }

        // Gestos táctiles (Swipe) - ahora en todo el contenedor
        let touchStartX = 0;
        let touchEndX = 0;

        if (messageContainer) {
            messageContainer.addEventListener("touchstart", function(event) {
                touchStartX = event.touches[0].clientX;
                pauseAutoScroll();
            });

            messageContainer.addEventListener("touchend", function(event) {
                touchEndX = event.changedTouches[0].clientX;
                handleSwipe();
                resumeAutoScroll();
            });
        }

        function handleSwipe() {
            if (touchStartX - touchEndX > 50) {
                nextMessage();
            } else if (touchEndX - touchStartX > 50) {
                prevMessage();
            }
        }

        // Iniciar auto-scroll
        startAutoScroll();

        // Cargar el primer mensaje al inicio
        updateMessage(0, false);
    });
</script>
