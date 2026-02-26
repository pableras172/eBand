@component('mail::message')
# Resumen de Pagos

## 📋 Información General

**Descripción:** {{ $descripcion }}  
**Fecha de Pago:** {{ $fechaPago }}

@if($payments && $payments->count() > 0)
## 💰 Detalle de Pagos

@component('mail::table')
| Descripción | Usuario | Total Pago |
|:------------|:--------|----------:|
@foreach($payments as $payment)
| {{ $payment->descripcion }} | {{ $payment->user->name }} | {{ number_format($payment->totalPago, 2, ',', '.') }} € |
@endforeach
|  | **TOTAL** | **{{ number_format($payments->sum('totalPago'), 2, ',', '.') }} €** |
@endcomponent

**Total de Pagos:** {{ $payments->count() }}

@else
No hay pagos registrados en este resumen.
@endif

---

Este es un resumen automático generado por **eBand**.

Saludos,  
**eBand** - Sistema de Gestión para Bandas de Música

@endcomponent
