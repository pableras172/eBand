<x-mail::message>

{{-- Logo de la aplicación --}}
<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ url('/imagenes/logo.png') }}" alt="{{ config('app.name') }}" style="height: 100px;">
</div>

# 🔒 Restablecimiento de contraseña

Hola, **{{ $user }}** 👋

Recibimos una solicitud para restablecer tu contraseña en **{{ config('app.name') }}**.  

Haz clic en el botón a continuación para restablecerla:

<x-mail::button :url="$url" color="success">
Restablecer contraseña
</x-mail::button>

Si no solicitaste este cambio, puedes ignorar este mensaje.

Gracias,  
**El equipo de {{ config('app.name') }}** 🎶

</x-mail::message>
