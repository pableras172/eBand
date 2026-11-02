# Especificación de la Feature: Payments

**Feature Branch**: `[payments]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/Payment/`, `app/Models/Payment.php`, `app/Models/Paymentresume.php`, `routes/web.php` y `resources/views/livewire/payments/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Consultar y gestionar pagos existentes (Prioridad: P1)

Como usuario autorizado, quiero ver el listado de pagos, buscar por descripción o nombre de usuario y ordenar resultados para localizar rápidamente un pago concreto.

**Por qué esta prioridad**: el listado es la puerta de entrada del módulo y permite operar sobre los pagos ya creados.

**Prueba independiente**: abrir el listado de pagos, aplicar búsqueda y ordenación, y comprobar que la paginación y el filtrado respetan el usuario visible o seleccionado.

**Escenarios de aceptación**:

1. **Dado** que accedo al listado de pagos, **cuando** la vista se renderiza, **entonces** se muestran los pagos asociados al usuario permitido y ordenados según el criterio actual.
2. **Dado** que escribo un texto en la búsqueda, **cuando** se refresca la lista, **entonces** se filtran los pagos por nombre de usuario o descripción.
3. **Dado** que solicito eliminar un pago, **cuando** confirmo la acción, **entonces** el pago se borra y la interfaz deja de mostrarlo.

---

### Historia de usuario 2 - Crear pagos y resúmenes de pago (Prioridad: P1)

Como administrador, quiero generar pagos a partir de actuaciones dentro de un rango de fechas para crear resúmenes y asignar importes a cada usuario implicado.

**Por qué esta prioridad**: la creación de pagos es el flujo central del módulo y produce los registros contables y operativos que consumen el resto de vistas.

**Prueba independiente**: ejecutar el formulario de creación con un usuario y un rango de fechas válidos, comprobando que se crean el `Paymentresume`, los `Payment` asociados y la relación con `ListasUser`.

**Escenarios de aceptación**:

1. **Dado** que soy administrador, **cuando** abro la pantalla de creación, **entonces** el formulario carga la fecha de pago actual y la lista de usuarios disponibles.
2. **Dado** que indico un rango de fechas válido, **cuando** consulto actuaciones, **entonces** se recuperan las actuaciones aplicables al pago según el usuario o el selector global.
3. **Dado** que guardo un pago válido, **cuando** termina la transacción, **entonces** se crea el resumen de pago, se crean los pagos individuales necesarios y se actualizan los `ListasUser` con importes y referencia de pago.

---

### Historia de usuario 3 - Editar, confirmar o rechazar pagos y enviar el detalle por email (Prioridad: P2)

Como usuario autorizado, quiero revisar un pago, confirmar su estado o indicar que no lo confirmo con observaciones, y poder enviar el detalle por email.

**Por qué esta prioridad**: completa el ciclo operativo del pago y da trazabilidad sobre su validación por parte del usuario.

**Prueba independiente**: abrir un pago existente, confirmar o rechazar su estado con observaciones y verificar que la acción se persiste y que el envío por email se intenta correctamente.

**Escenarios de aceptación**:

1. **Dado** que abro un pago existente, **cuando** se carga el formulario, **entonces** veo sus datos y el estado de confirmación del usuario.
2. **Dado** que confirmo el pago, **cuando** se guarda la acción, **entonces** el campo de confirmación queda activado.
3. **Dado** que rechazo el pago con observaciones, **cuando** guardo el formulario, **entonces** el rechazo se persiste solo si existen observaciones y se muestra un error si no las hay.
4. **Dado** que envío el detalle del pago, **cuando** el usuario tiene correo disponible, **entonces** se envía el email con el detalle y, si procede, una copia al usuario autenticado.

### Casos límite

- ¿Qué ocurre si el usuario no tiene permisos de administrador para crear pagos?
- ¿Qué ocurre si un pago no existe al intentar abrirlo o borrarlo?
- ¿Qué ocurre si el usuario del pago no tiene correo electrónico para el envío?
- ¿Qué ocurre si el rango de fechas no devuelve actuaciones o la transacción falla?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir consultar el listado de pagos con paginación, búsqueda y ordenación.
- **FR-002**: El sistema debe limitar el acceso al listado y al detalle de pagos según el usuario autenticado y sus relaciones permitidas.
- **FR-003**: El sistema debe permitir eliminar un pago autorizado desde la vista de detalle o listado.
- **FR-004**: El sistema debe permitir preparar pagos a partir de un rango de fechas y un usuario concreto o global.
- **FR-005**: El sistema debe crear un `Paymentresume` al guardar un pago generado desde actuaciones.
- **FR-006**: El sistema debe crear los pagos necesarios y asociarlos a `ListasUser` con los importes calculados.
- **FR-007**: El sistema debe validar la fecha de pago, la descripción y el rango de fechas antes de guardar.
- **FR-008**: El sistema debe permitir confirmar o rechazar un pago existente y persistir el estado resultante.
- **FR-009**: El sistema debe exigir observaciones para rechazar un pago.
- **FR-010**: El sistema debe permitir enviar por email el detalle de un pago a su usuario y, si aplica, al usuario autenticado.
- **FR-011**: El sistema debe mantener compatibilidad con las vistas Livewire y Blade existentes del módulo.

### Superficie Laravel / Livewire

- **Rutas**: `routes/web.php` contiene `payments.index`, `payments.user`, `payments.create`, `payments.edit` y `pdf.paymentresume`.
- **Livewire**: `app/Livewire/Payment/PaymentIndex.php`, `app/Livewire/Payment/PaymentCreate.php`, `app/Livewire/Payment/PaymentEdit.php` y `app/Livewire/Payment/PaymentListasUsersDetail.php` controlan el comportamiento principal.
- **Vistas**: `resources/views/livewire/payments/index.blade.php`, `create.blade.php`, `edit.blade.php` y `paymentresumes/payments-detail.blade.php` forman la interfaz visible.
- **Modelos**: `Payment`, `Paymentresume`, `ListasUser`, `Listas`, `Actuacion` y `User` participan en la persistencia y el cálculo.
- **Correo**: `App\Mail\PaymentDetail` se usa para el envío del detalle del pago.

### Entidades clave

- **Payment**: representa un pago individual asociado a un usuario, con importes, observaciones y estado de confirmación.
- **Paymentresume**: agrupa el resumen o cabecera de una tanda de pagos generados.
- **ListasUser**: almacena la participación de un usuario en una lista y recibe la referencia y los importes calculados del pago.
- **Actuacion**: proporciona el universo de actuaciones que entran en el cálculo del pago.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario autorizado puede abrir el listado de pagos y navegarlo con búsqueda, ordenación y paginación.
- **SC-002**: Un administrador puede generar pagos válidos a partir de un rango de fechas y obtener un resumen persistido.
- **SC-003**: El flujo de creación actualiza `ListasUser` con el pago y los importes calculados sin romper la transacción.
- **SC-004**: Un usuario autorizado puede confirmar o rechazar un pago y el estado queda guardado correctamente.
- **SC-005**: El módulo puede enviar el detalle del pago por email cuando existe dirección válida.
- **SC-006**: Las vistas existentes del módulo siguen funcionando sin romper la navegación ni las relaciones entre datos.

## Suposiciones

- Se reutiliza la autenticación y autorización existente de Laravel.
- El módulo mantiene la estructura monolítica actual y no se extrae a un servicio separado.
- El cálculo de importes hereda las reglas ya codificadas en Livewire y modelos existentes.
- La cobertura de pruebas del módulo parece inexistente o muy limitada, así que esta migración documenta comportamiento observado, no validado por tests dedicados.