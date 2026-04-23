<x-mail::message>
# Disponibilidad actualizada

El músico **{{ $username }}** ha comunicado su disponibilidad para una actuación próxima.

<x-mail::panel>
**Estado**  
{{ $customText }}

**Actuación**  
{{ $actuacio->descripcion }}

**Fecha**  
{{ \Carbon\Carbon::parse($actuacio->fechaActuacion)->format('d/m/Y · H:i') }}
</x-mail::panel>

Accede a la lista para revisar el estado actual del grupo.

<x-mail::button :url="$url" color="primary">
Ver lista de actuación
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
