# Tareas: Payments

**Entrada**: Documentos de diseño en `specs/payments/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y toca comportamiento visible y operativo.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de implementación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar los puntos de entrada reales del módulo antes de documentar cada flujo.

- [x] T001 Confirmar el alcance del módulo en `app/Livewire/Payment/`, `app/Models/Payment.php`, `app/Models/Paymentresume.php` y `resources/views/livewire/payments/`
- [x] T002 [P] Identificar las rutas afectadas en `routes/web.php` para listado, creación, edición, detalle y PDF del resumen de pago
- [x] T003 [P] Verificar la relación de `Payment` con `Paymentresume`, `User` y `ListasUser`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el listado de pagos usa paginación, búsqueda y ordenación en `PaymentIndex`
- [x] T005 [P] Revisar que la creación de pagos valida `fechaPago`, `descripcion`, `fechaInicio` y `fechaFin` en `PaymentCreate`
- [x] T006 [P] Revisar que la edición permite confirmar, rechazar y enviar el detalle por email en `PaymentEdit`
- [x] T007 Revisar que el detalle de `ListasUser` asociado a un pago existe en `PaymentListasUsersDetail`
- [x] T008 Revisar que la autorización protege las operaciones de listado, creación, edición y borrado
- [x] T009 Confirmar que el módulo se apoya en la estructura monolítica existente sin dependencias externas nuevas

**Punto de control**: La base está lista; el módulo ya existe y puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Consultar y gestionar pagos existentes (Prioridad: P1)

**Objetivo**: Documentar el listado operativo de pagos con búsqueda, ordenación y borrado.

**Prueba independiente**: Abrir el listado de pagos y comprobar que se pueden filtrar, ordenar y eliminar registros autorizados.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar `PaymentIndex::getRowsQueryProperty()` y su filtrado por nombre o descripción
- [x] T011 [P] [US1] Verificar `PaymentIndex::confirmDeletion()` y `delete()` sobre un pago existente

### Implementación para la historia 1

- [x] T012 [P] [US1] Mantener la acción `mount()` en `app/Livewire/Payment/PaymentIndex.php` como punto de entrada del listado
- [x] T013 [P] [US1] Mantener la vista `resources/views/livewire/payments/index.blade.php` como salida principal de listados
- [x] T014 [US1] Preservar la paginación, búsqueda y ordenación del listado
- [x] T015 [US1] Mantener el filtrado por usuario permitido o por usuario autenticado según la ruta
- [x] T016 [US1] Confirmar que el borrado requiere autorización y limpia el estado de confirmación
- [x] T017 [US1] Validar que la historia funciona independientemente del flujo de creación o edición

**Punto de control**: La historia 1 queda documentada y lista como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Crear pagos y resúmenes de pago (Prioridad: P1)

**Objetivo**: Documentar la generación de pagos desde actuaciones y su persistencia en transacción.

**Prueba independiente**: Ejecutar la creación con un rango de fechas válido y comprobar que se generan `Paymentresume`, `Payment` y actualizaciones en `ListasUser`.

### Pruebas para la historia 2

- [x] T018 [P] [US2] Verificar la inicialización del formulario en `PaymentCreate::mount()`
- [x] T019 [P] [US2] Verificar que `consultarActuaciones()` filtra actuaciones por rango, usuario y regla de no aplicapago

### Implementación para la historia 2

- [x] T020 [P] [US2] Documentar el flujo de creación en `app/Livewire/Payment/PaymentCreate.php`
- [x] T021 [P] [US2] Documentar la transacción que crea `Paymentresume` y los pagos asociados
- [x] T022 [US2] Documentar el cálculo de importes por actuación, coche y furgoneta
- [x] T023 [US2] Mantener la asociación de pagos con `ListasUser` y la actualización de totales
- [x] T024 [US2] Mantener la salida a `payments.index` tras una creación satisfactoria o fallida
- [x] T025 [US2] Confirmar que la historia queda acotada al flujo administrativo y no rompe el listado

**Punto de control**: La historia 2 queda completa y es el núcleo contable-operativo del módulo.

---

## Fase 5: Historia de usuario 3 - Editar, confirmar o rechazar pagos y enviar el detalle por email (Prioridad: P2)

**Objetivo**: Documentar la edición del pago, su confirmación o rechazo y el envío de correos de detalle.

**Prueba independiente**: Abrir un pago existente, cambiar su estado y comprobar que el email se intenta enviar con los destinatarios correctos.

### Pruebas para la historia 3

- [x] T026 [P] [US3] Verificar `PaymentEdit::save()`, `confirm()` y `noConfirmar()`
- [x] T027 [P] [US3] Verificar `PaymentEdit::print()` y la gestión del caso sin email disponible

### Implementación para la historia 3

- [x] T028 [P] [US3] Documentar la ruta de edición `app/Livewire/Payment/PaymentEdit.php`
- [x] T029 [P] [US3] Documentar la persistencia del estado de confirmación del pago
- [x] T030 [US3] Documentar la exigencia de observaciones para rechazar un pago
- [x] T031 [US3] Mantener el envío de `App\Mail\PaymentDetail` al usuario del pago y al autenticado cuando corresponda
- [x] T032 [US3] Mantener la relación con la vista `resources/views/livewire/payments/edit.blade.php`
- [x] T033 [US3] Confirmar que los fallos de email o de validación devuelven mensajes comprensibles o eventos de error

**Punto de control**: La historia 3 queda documentada como la capa operativa complementaria.

---

## Fase 6: Detalle de listas por pago

**Objetivo**: Documentar el submódulo de detalle y mantenimiento de `ListasUser` ligado a un pago.

**Prueba independiente**: Abrir el detalle de un pago y añadir, editar o eliminar líneas de `ListasUser` asociadas.

### Pruebas para esta fase

- [x] T034 [P] Verificar `PaymentListasUsersDetail::getRowsQueryProperty()` y el ordenado por fecha de actuación
- [x] T035 [P] Verificar `PaymentListasUsersDetail::deleteListasUser()` con autorización

### Implementación para esta fase

- [x] T036 [P] Documentar la vista `resources/views/livewire/payments/paymentresumes/payments-detail.blade.php`
- [x] T037 [P] Documentar la creación y edición modal de `ListasUser` desde `PaymentListasUsersDetail`
- [x] T038 [P] Documentar la asociación del detalle al `payment_id` actual antes de guardar
- [x] T039 Documentar la búsqueda, ordenación y paginación del detalle asociado al pago
- [x] T040 Confirmar que el detalle de listas no rompe el resto del flujo de Payments

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T041 [P] Documentar que no se añadieron nuevas dependencias ni servicios externos para esta migración
- [x] T042 [P] Documentar que la cobertura de pruebas es inexistente o no se detectó en el módulo Payments
- [x] T043 Revisar que no se introducen conflictos con autenticación, permisos ni middleware existente
- [x] T044 Revisar consistencia entre componentes Livewire, modelos y vistas Blade del módulo
- [x] T045 Registrar que existen oportunidades de ampliar pruebas para creación, emails y detalle por `ListasUser`
- [x] T046 Marcar la feature como migrada con gap de cobertura, no como feature nueva

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende de las demás
- **Historia 2**: es la base del módulo y alimenta la mayor parte del comportamiento operativo
- **Historia 3**: depende del detalle de pagos, pero sigue siendo independiente en la práctica

### Dentro de cada historia

- Las pruebas van antes que la implementación documental correspondiente
- Los modelos y relaciones se documentan antes que las operaciones que dependen de ellos
- La autorización y validación se mantienen antes de las acciones de persistencia o notificación

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010 y T011 se pueden revisar en paralelo
- T018 y T019 se pueden revisar en paralelo
- T026 y T027 se pueden revisar en paralelo
- T034 y T035 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Consolidar Historia 2 porque es donde se concentra la lógica principal del módulo.
3. Validar Historia 1 como consulta y gestión del listado.
4. Validar Historia 3 como capa operativa complementaria.
5. Cerrar el detalle de `ListasUser` como submódulo asociado.

### Entrega incremental

1. Base documental del módulo.
2. Listado de pagos.
3. Creación y resumen de pagos.
4. Edición, confirmación, rechazo y correo.
5. Detalle por listas asociado al pago.

### Estrategia de equipo

1. Una persona revisa el listado y las rutas.
2. Otra persona revisa creación, edición y emails.
3. Otra persona revisa el detalle por listas y la documentación de pruebas.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La cobertura detectada es limitada o ausente y conviene ampliarla si se quiere cerrar más comportamiento operativo.