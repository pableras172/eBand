@component('mail::message')
# 🎵 Nuevo mensaje de contacto

Has recibido un nuevo mensaje desde el formulario de contacto de **eBand**.

---

## 👤 Datos del contacto

**Nombre:** {{ $nombre }}  
**Banda:** {{ $banda }}  
**Teléfono:** {{ $telefono ?? 'No proporcionado' }}  
**Email:** [{{ $email }}](mailto:{{ $email }})

---

## 💬 Mensaje

{{ $informacion }}

---

@component('mail::button', ['url' => 'mailto:' . $email])
Responder por email
@endcomponent

<small style="color: #999;">Este mensaje ha sido enviado desde el formulario de contacto de eBand.</small>

Gracias,<br>
{{ config('app.name') }}
@endcomponent
