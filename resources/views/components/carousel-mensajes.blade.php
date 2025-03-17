@php
    $mensajes = App\Models\Comment::with('user', 'actuacion')
        ->whereHas('actuacion', function ($query) {
            $query->where('fechaActuacion', '>=', now());
        })
        ->get();
@endphp


<div class="w-full max-w-md bg-white shadow-lg rounded-lg p-4 text-center overflow-hidden">
    {{-- Contenedor del mensaje --}}
    <div class="flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-blue-600 animate-bounce" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
        </svg>
        <h1 class="text-xl font-bold text-gray-800">
            {{__('Ultimos mensajes')}}
        </h1>
    </div>
   
    @if ($mensajes->isNotEmpty())
        @php
            $mensaje = $mensajes->first();
        @endphp

        <div class="relative grid grid-cols-1 gap-4 p-4 mt-2 mb-1 border rounded-lg bg-white shadow-lg">
            <div class="relative flex gap-4">
                {{-- Contenedor del Avatar --}}
                <div class="relative w-20 h-20 mx-auto aspect-square">
                    <img id="carousel-avatar" class="w-full h-full rounded-full object-cover border-4 border-blue-500"
                        src="{{ $mensaje->user->profile_photo_url }}" alt="{{ $mensaje->user->name }}" />

                    {{-- Badge con icono del instrumento --}}
                    <div
                        class="absolute bottom-0 right-0 w-6 h-6 bg-white rounded-full border-2 border-blue-500 flex items-center justify-center">
                        <img id="carousel-instrument" src="{{ asset('storage/imagenes/instruments/' . $mensaje->user->instrument->icon) }}"
                            alt="{{ $mensaje->user->instrument }}" class="w-4 h-4">
                    </div>
                </div>

                <div class="flex flex-col w-full">
                    <div class="flex flex-row justify-between">
                        {{-- Nombre del usuario --}}
                        <p id="carousel-user" class="relative text-l whitespace-nowrap truncate overflow-hidden">
                            {{ $mensaje->user->name }}
                        </p>
                        <p id="carousel-date" class="text-gray-400 text-sm">
                            {{ \Carbon\Carbon::parse($mensaje->created_at)->format('d/m/Y') }}
                        </p>
                    </div>
                    <hr>
                    <div class="mt-2">
                        {{-- Contenido del comentario --}}
                        <p id="carousel-message" class="text-gray-500">
                            {{ $mensaje->comment }}
                        </p>
                    </div>
                    <hr>
                    <div class="mt-2 flex justify-end">
                        <p id="actuacionName">{{ $mensaje->actuacion->descripcion }} </p>
                        <a id = "enlaceActuacion" href="{{ route('listas.actuacion', ['actuacion_id' =>  $mensaje->actuacion->id]) }}">
                            <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools --> <title>ic_fluent_arrow_forward_24_regular</title> <desc>Created with Sketch.</desc> <g id="🔍-System-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_arrow_forward_24_regular" fill="#b06d36" fill-rule="nonzero"> <path d="M14.6470979,6.30372605 L14.7197247,6.21961512 C14.9860188,5.95337607 15.402685,5.92921307 15.6962739,6.14709787 L15.7803849,6.21972471 L20.7769976,11.21737 C21.0430885,11.4835159 21.0673924,11.8999028 20.8498298,12.1934928 L20.777305,12.2776129 L15.7806923,17.2810585 C15.4879993,17.5741518 15.0131257,17.5744763 14.7200324,17.2817833 C14.453584,17.0156987 14.4290932,16.5990517 14.646747,16.3052914 L14.7193077,16.2211234 L18.4301989,12.504 L3.75019891,12.504946 C3.37050315,12.504946 3.05670795,12.2227922 3.00704553,11.8567166 L3.00019891,11.754946 C3.00019891,11.3752503 3.28235279,11.0614551 3.64842835,11.0117927 L3.75019891,11.004946 L18.4431989,11.004 L14.7196151,7.28027529 C14.4533761,7.01398122 14.4292131,6.59731504 14.6470979,6.30372605 L14.7197247,6.21961512 L14.6470979,6.30372605 Z" id="🎨-Color"> </path> </g> </g> </g></svg>
                        </a>                       
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-gray-500 text-center">{{__('No hay mensajes recientes')}}</p>
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

        const messageElement = document.getElementById("carousel-message");
        const nameElement = document.getElementById("carousel-user");
        const dateElement = document.getElementById("carousel-date");
        const avatarElement = document.getElementById("carousel-avatar");
        const instrumentElement = document.getElementById("carousel-instrument");
        const actuacionName = document.getElementById("actuacionName");
        const enlaceActuacion = document.getElementById("enlaceActuacion");

        function updateMessage(index) {
            if (messages.length === 0) {
                messageElement.textContent = "No hay mensajes recientes";
                return;
            }

            const msg = messages[index];
            nameElement.textContent = msg.user;
            messageElement.textContent = msg.comment;
            dateElement.textContent = msg.date;
            avatarElement.src = msg.photo;
            instrumentElement.src = msg.instrument;
            actuacionName.textContent = msg.actuacionName;
            enlaceActuacion.href = msg.enlaceActuacion;
        }

        function nextMessage() {
            currentIndex = (currentIndex + 1) % messages.length;
            updateMessage(currentIndex);
        }

        // Auto desplazamiento cada 5 segundos
        setInterval(nextMessage, 5000);

        // Gestos táctiles (Swipe)
        let touchStartX = 0;
        let touchEndX = 0;

        messageElement.addEventListener("touchstart", function(event) {
            touchStartX = event.touches[0].clientX;
        });

        messageElement.addEventListener("touchend", function(event) {
            touchEndX = event.changedTouches[0].clientX;
            handleSwipe();
        });

        function handleSwipe() {
            if (touchStartX - touchEndX > 50) {
                nextMessage();
            } else if (touchEndX - touchStartX > 50) {
                currentIndex = (currentIndex - 1 + messages.length) % messages.length;
                updateMessage(currentIndex);
            }
        }

        // Cargar el primer mensaje al inicio
        updateMessage(0);
    });
</script>
