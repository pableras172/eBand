<x-mail::message>
# 👋 ¡Nuevo usuario registrado en {{ config('app.name') }}!

Hola administrador,  

Un nuevo usuario se ha registrado en **{{ config('app.name') }}**.  
Aquí tienes los detalles:

- 👤 **Usuario**: **{{ $username }}**

🔍 **Accede para revisarlo y activarlo**:

<x-mail::button :url="$url" color="primary">
🔗 Ver usuario
</x-mail::button>

¡Gracias por tu atención! 😊

Atentamente,  
**El equipo de {{ config('app.name') }}** 🎶
</x-mail::message>
