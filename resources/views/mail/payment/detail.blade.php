@component('mail::message')
# Detalle de Pago

Hola **{{ $userName }}**,

Te enviamos el detalle de tu pago:

## 📋 Información del Pago

**Actuación:** {{ $actuacionNombre }}  

@if($payment->fechaInicio && $payment->fechaInicio instanceof \Carbon\Carbon)
**Desde:** {{ $payment->fechaInicio->format('d/m/Y') }}  
@elseif($payment->fechaInicio)
**Desde:** {{ $payment->fechaInicio }}  
@endif
@if($payment->fechaFin && $payment->fechaFin instanceof \Carbon\Carbon)
**Hasta:** {{ $payment->fechaFin->format('d/m/Y') }}  
@elseif($payment->fechaFin)
**Hasta:** {{ $payment->fechaFin }}  
@endif
**Estado:** {{ $payment->confirmadausuaroi ? '✅ Confirmado' : '⏳ Pendiente de confirmación' }}

@if($listasUsers && $listasUsers->count() > 0)
## 🎭 Actuaciones Pagadas

@component('mail::table')
| Fecha | Actuación | Coche | Acto | Total |
|:------|:----------|------:|-----:|------:|
@foreach($listasUsers as $listasUser)
| {{ \Carbon\Carbon::parse($listasUser->fechaActuacion)->format('d/m/Y') }} | {{ $listasUser->actuacion_nombre }} | {{ number_format($listasUser->totalCoche, 2, ',', '.') }} € | {{ number_format($listasUser->totalActuacion, 2, ',', '.') }} € | {{ number_format($listasUser->totalActo, 2, ',', '.') }} € |
@endforeach
**Importe:** {{ $importe }} €  
@endcomponent
@endif

@if($observaciones)
## 📝 Observaciones

{{ $observaciones }}
@endif

---

Si tienes alguna duda o consulta sobre este pago, no dudes en contactar con la administración de tu banda.

Saludos,  
**eBand** - Sistema de Gestión para Bandas de Música

@endcomponent
