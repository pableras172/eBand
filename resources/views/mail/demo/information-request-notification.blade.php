<x-mail::message>
# Nueva solicitud de informacion desde la demo

Se ha recibido una nueva solicitud desde el entorno demo de eBand.

- Nombre y apellidos: {{ $nombreApellidos }}
- Email de contacto: {{ $emailContacto }}
- Telefono de contacto: {{ $telefonoContacto }}
- Nombre de la banda: {{ $nombreBanda ?: 'No indicado' }}
- Numero de musicos: {{ $numeroMusicos ?: 'No indicado' }}

## Notas

{{ $notas }}

{{ config('app.name') }}
</x-mail::message>
