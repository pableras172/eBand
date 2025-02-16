<x-mail::message>
# 🎺 ¡Nueva actualización en una actuación!

Hola administrador,  

El usuario **{{ $username }}** ha indicado lo siguiente para la próxima actuación:

📢 **Estado indicado**:  
**{{ $customText }}**

🎶 **Actuación**:  
**{{ $actuacio->descripcion }}**

📆 **Fecha de la actuación**:  
**{{ \Carbon\Carbon::parse($actuacio->fechaActuacion)->format('d/m/Y H:i') }}**

🔍 **Accede para gestionar la lista:**

<x-mail::button :url="$url" color="primary">
📋 Ver lista de actuación
</x-mail::button>

---

Gracias por tu dedicación,  
**El equipo de {{ config('app.name') }}** 🎶
</x-mail::message>
