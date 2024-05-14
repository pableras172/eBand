<x-mail::message>
Hola, el usuario {{$username}} ha indicado que no esta disponible para la actuacion:
{{$actuacio->descripcion}}
Fecha: {{$actuacio->fechaActuacion}}

Se marcará como no disponible.

<x-mail::button :url="$url">
Acceder a la lista
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
