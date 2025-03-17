<div class="flex flex-col items-center space-y-2">
   <x-lottie style="width: 300px; height: 200px;" path="{{ asset('storage/animaciones/estadisticas.json') }}" loop="true" autoplay="true" />
   
   <div class="flex items-center space-x-2">
       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
       </svg>
       
       <a href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}" class="font-semibold hover:underline">
           {{ __('Les meves actuacions') }}
       </a>
   </div>
</div>