<x-mail::message>
# Gracias por tu interes, {{ $nombre }}

Tu acceso a la demo de eBand ya esta activado.

Desde este momento puedes explorar como gestionar actuaciones, pagos, contratos y equipo de forma centralizada.

Si quieres una demo guiada o resolver dudas de implantacion, responde a este correo y te ayudamos personalmente.

<x-mail::button :url="url('/')">
Entrar en eBand
</x-mail::button>

Un saludo,<br>
{{ config('app.name') }}
</x-mail::message>
