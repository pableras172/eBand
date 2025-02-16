<x-mail::message>
# 🛠️ Verificación de correo electrónico

Hola, **{{ $user }}** 👋

Por favor, haz clic en el siguiente botón para verificar tu dirección de correo electrónico y activar tu cuenta en **{{ config('app.name') }}**.

<x-mail::button :url="$url" color="success">
✅ Verificar mi correo
</x-mail::button>

Si no solicitaste esta verificación, puedes ignorar este mensaje.

Gracias,  
**El equipo de {{ config('app.name') }}** 🎶
</x-mail::message>
