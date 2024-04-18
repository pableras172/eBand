<x-mail::message>
Hola, un nuevo usuario se ha dado de alta en {{ config('app.name') }}.
Usuario: {{$username}};
Accede para revisarlo y activarlo

<x-mail::button :url="$url">
Ver usuario
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
