<x-mail::message>
# Nuevo interesado en la demo

Se ha registrado un nuevo contacto para probar eBand.

- Nombre: {{ $nombreCompleto }}
- Email: {{ $email }}
- Lead ID: {{ $leadId }}
- IP: {{ $ipAddress ?? 'No disponible' }}

<x-mail::button :url="url('/login')">
Ir a eBand
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
