<x-mail::message>
Hola, el usuario {{$username}} ha indicado <strong>{{$customText}}</strong> para la actuacion:
<strong>{{$actuacio->descripcion}}</strong>
Fecha: {{$actuacio->fechaActuacion}}

Se marcará como <strong>{{$customText}}</strong>.

<x-mail::button :url="$url">
Acceder a la lista
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
