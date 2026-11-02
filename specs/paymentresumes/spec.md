# Especificación de la Feature: Paymentresume

**Feature Branch**: `[paymentresumes]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/Paymentresume/`, `app/Models/Paymentresume.php`, `app/Livewire/Dashboard/Paymentresumes/Forms/`, `routes/web.php` y `resources/views/livewire/payments/paymentresumes/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Consultar y buscar resúmenes de pago (Prioridad: P1)

Como usuario autorizado, quiero ver los resúmenes de pago, buscarlos por usuario o descripción y ordenarlos para localizar rápidamente el lote de pagos que necesito revisar.

**Por qué esta prioridad**: el listado es la puerta de entrada del módulo y concentra la consulta operativa diaria de resúmenes.

**Prueba independiente**: abrir el listado de resúmenes de pago, aplicar búsqueda y ordenación, y comprobar que la paginación funciona.

**Escenarios de aceptación**:

1. **Dado** que accedo al listado de resúmenes de pago, **cuando** la vista se renderiza, **entonces** se muestran los resúmenes ordenados según el criterio actual.
2. **Dado** que escribo un término en la búsqueda, **cuando** se refresca la lista, **entonces** solo aparecen resúmenes cuyo usuario o descripción coinciden.
3. **Dado** que cambio el orden de la tabla, **cuando** se refresca la vista, **entonces** el listado se reordena por el campo seleccionado.

---

### Historia de usuario 2 - Crear y editar resúmenes de pago (Prioridad: P1)

Como usuario autorizado, quiero crear y editar un resumen de pago con descripción, usuario, fecha y documento opcional para organizar correctamente los pagos agrupados.

**Por qué esta prioridad**: la creación y edición son el flujo central del módulo y definen el contenedor de los pagos individuales.

**Prueba independiente**: crear un resumen válido, abrirlo en edición y comprobar que la persistencia conserva los datos y la fecha formateada.

**Escenarios de aceptación**:

1. **Dado** que abro la pantalla de creación, **cuando** se monta el componente, **entonces** puedo seleccionar un usuario y completar la información del resumen.
2. **Dado** que relleno descripción y usuario válidos, **cuando** guardo, **entonces** el resumen se crea correctamente.
3. **Dado** que edito un resumen existente, **cuando** guardo cambios válidos, **entonces** el resumen se actualiza.

---

### Historia de usuario 3 - Gestionar pagos asociados a un resumen y enviar el detalle por email (Prioridad: P2)

Como usuario autorizado, quiero añadir, editar y borrar pagos dentro de un resumen y enviar un detalle por email para cerrar el ciclo operativo del lote.

**Por qué esta prioridad**: completa el ciclo del resumen y lo conecta con el detalle operativo de pagos.

**Prueba independiente**: abrir un resumen, crear un pago asociado, editarlo y borrar uno existente, y después enviar el detalle por correo.

**Escenarios de aceptación**:

1. **Dado** que abro el detalle de pagos de un resumen, **cuando** se renderiza la vista, **entonces** veo los pagos asociados con su orden actual.
2. **Dado** que creo o edito un pago asociado, **cuando** guardo, **entonces** se persiste el pago dentro del resumen correcto.
3. **Dado** que envío el detalle del resumen por email, **cuando** el usuario autenticado tiene correo, **entonces** se genera y envía el mensaje con el contenido del resumen.

### Casos límite

- ¿Qué ocurre si el usuario no tiene permisos para crear, editar o eliminar resúmenes?
- ¿Qué ocurre si se intenta editar un resumen inexistente?
- ¿Qué ocurre si el usuario autenticado no tiene correo para el envío del detalle?
- ¿Qué ocurre si el documento es inválido o la URL no es correcta?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir consultar resúmenes de pago con paginación, búsqueda y ordenación.
- **FR-002**: El sistema debe permitir crear resúmenes con descripción, usuario, fecha y documento opcional.
- **FR-003**: El sistema debe permitir editar resúmenes de pago existentes.
- **FR-004**: El sistema debe mantener la fecha de creación en un formato consistente al cargar formularios de edición.
- **FR-005**: El sistema debe permitir consultar, crear, editar y borrar pagos asociados a un resumen.
- **FR-006**: El sistema debe permitir enviar el detalle del resumen por email al usuario autenticado cuando exista correo.
- **FR-007**: El sistema debe permitir ver el detalle de pagos asociados a un resumen con búsqueda y ordenación.
- **FR-008**: El sistema debe mantener compatibilidad con las vistas Livewire y Blade existentes del módulo.

### Superficie Laravel / Livewire

- **Rutas**: `routes/web.php` contiene `paymentresumes.index`, `paymentresumes.create` y `paymentresumes.edit`.
- **Livewire**: `app/Livewire/Paymentresume/PaymentresumeIndex.php`, `PaymentresumeCreate.php`, `PaymentresumeEdit.php` y `PaymentresumePaymentsDetail.php` controlan el comportamiento principal.
- **Vistas**: `resources/views/livewire/payments/paymentresumes/index.blade.php`, `create.blade.php`, `edit.blade.php` y `payments-detail.blade.php` forman la interfaz visible.
- **Formularios**: `app/Livewire/Dashboard/Paymentresumes/Forms/CreateForm.php`, `UpdateForm.php`, `CreateDetailForm.php` y `UpdateDetailForm.php` encapsulan validación y persistencia.
- **Modelo**: `Paymentresume` centraliza el resumen y su relación con pagos y usuario.

### Entidades clave

- **Paymentresume**: representa la cabecera o lote de pagos.
- **Payment**: representa los pagos individuales vinculados a un resumen.
- **User**: autor o destinatario del resumen, según el contexto.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario autorizado puede abrir el listado de resúmenes y navegarlo con búsqueda y paginación.
- **SC-002**: Un usuario autorizado puede crear un resumen válido y volver a editarlo sin perder contexto.
- **SC-003**: Un usuario autorizado puede añadir, editar y borrar pagos asociados a un resumen.
- **SC-004**: Un usuario autenticado con correo puede recibir por email el detalle del resumen.
- **SC-005**: El detalle del resumen muestra los pagos relacionados con búsqueda y ordenación.
- **SC-006**: Las vistas existentes del módulo siguen funcionando sin romper la navegación ni las relaciones entre datos.

## Suposiciones

- Se reutiliza la autenticación y autorización existente de Laravel.
- El módulo mantiene la estructura monolítica actual y no se extrae a un servicio separado.
- El envío de email del resumen forma parte del comportamiento existente y no de un flujo nuevo.
- La cobertura de pruebas del módulo parece inexistente, así que esta migración documenta comportamiento observado, no validado por tests dedicados.