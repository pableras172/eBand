@component('mail::message')

{{-- Logo de la aplicación --}}
<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ url('/imagenes/logo.png') }}" alt="{{ config('app.name') }}" style="height: 100px;">
</div>

# 🎵 Agenda Semanal de Actuaciones

@if($userName)
Hola **{{ $userName }}**,
@else
Hola,
@endif

Te informamos de la programación de actuaciones para esta semana del **{{ $fechaInicio }}** al **{{ $fechaFin }}**.

@if($actuaciones && $actuaciones->count() > 0)
## 📅 Actuaciones Programadas

@component('mail::table')
| Fecha | Actuación | Tipo | Ubicación |
|:------|:----------|:-----|:----------|
@foreach($actuaciones as $actuacion)
| {{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y H:i') }} | **{{ $actuacion->descripcion }}** | {{ $actuacion->tipoactuacion ? $actuacion->tipoactuacion->nombre : '-' }} | {{ $actuacion->contrato ? $actuacion->contrato->descripcion : '-' }} |
@endforeach
@endcomponent

**Total de actuaciones:** {{ $actuaciones->count() }}

@component('mail::button', ['url' => tenant_route('dashboard', fallbackPath: '/dashboard')])
Ver Agenda Completa
@endcomponent

@else
## ℹ️ Sin Actuaciones

No hay actuaciones programadas para esta semana.

@component('mail::button', ['url' => tenant_route('dashboard', fallbackPath: '/dashboard')])
Consultar Agenda
@endcomponent
@endif

---

Gracias,<br>
{{ config('app.name') }}

@slot('subcopy')
Si tienes alguna duda o consulta, puedes acceder a la plataforma en cualquier momento.
@endslot
@endcomponent
