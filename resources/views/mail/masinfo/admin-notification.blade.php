<x-mail::message>
# Nuevo contacto desde /masinfo

Se ha recibido un nuevo formulario publico.

- Tipo de solicitud: {{ $tipoSolicitud }}
- Nombre y apellidos: {{ $nombreCompleto }}
- Email de contacto: {{ $emailContacto }}
- Telefono de contacto: {{ $telefonoContacto }}
- Comparsa / asociacion / banda: {{ $entidad ?: 'No indicado' }}
- Municipio: {{ $municipio ?: 'No indicado' }}
- Lead ID: {{ $leadId }}
- IP: {{ $ipAddress ?? 'No disponible' }}

@if($mensaje)
## Mensaje

{{ $mensaje }}
@endif

<x-mail::button :url="url('/login')">
Ir a eBand
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
