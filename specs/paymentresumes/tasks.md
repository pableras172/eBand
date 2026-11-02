# Tareas: Paymentresume

**Entrada**: Documentos de diseño en `specs/paymentresumes/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y toca comportamiento visible y operativo.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de implementación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar los puntos de entrada reales del módulo antes de documentar cada flujo.

- [x] T001 Confirmar el alcance del módulo en `app/Livewire/Paymentresume/`, `app/Livewire/Dashboard/Paymentresumes/Forms/`, `app/Models/Paymentresume.php` y `resources/views/livewire/payments/paymentresumes/`
- [x] T002 [P] Identificar las rutas afectadas en `routes/web.php` para listado, creación, edición y detalle de resúmenes
- [x] T003 [P] Verificar la relación de `Paymentresume` con `Payment` y `User`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el listado de resúmenes usa paginación, búsqueda y ordenación en `PaymentresumeIndex`
- [x] T005 [P] Revisar que la creación valida descripción, usuario y fecha opcional en `CreateForm` y `PaymentresumeCreate`
- [x] T006 [P] Revisar que la edición conserva el contexto del resumen y la fecha formateada en `UpdateForm` y `PaymentresumeEdit`
- [x] T007 Revisar que el detalle de pagos asociado existe en `PaymentresumePaymentsDetail`
- [x] T008 Revisar que la autorización protege las operaciones de listado, creación, edición, detalle y borrado
- [x] T009 Confirmar que el módulo se apoya en la estructura monolítica existente sin dependencias externas nuevas

**Punto de control**: La base está lista; el módulo ya existe y puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Consultar y buscar resúmenes de pago (Prioridad: P1)

**Objetivo**: Documentar el listado operativo de resúmenes de pago con búsqueda y ordenación.

**Prueba independiente**: Abrir el listado de resúmenes y comprobar que se pueden filtrar y ordenar.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar `PaymentresumeIndex::getRowsQueryProperty()` y su filtrado por usuario o descripción
- [x] T011 [P] [US1] Verificar `PaymentresumeIndex::confirmDeletion()` y `delete()` sobre un resumen existente

### Implementación para la historia 1

- [x] T012 [P] [US1] Mantener la acción `render()` en `app/Livewire/Paymentresume/PaymentresumeIndex.php` como punto de entrada del listado
- [x] T013 [P] [US1] Mantener la vista `resources/views/livewire/payments/paymentresumes/index.blade.php` como salida principal de listados
- [x] T014 [US1] Preservar la paginación, búsqueda y ordenación del listado
- [x] T015 [US1] Mantener la eliminación autorizada de resúmenes desde el listado
- [x] T016 [US1] Confirmar que la historia funciona independientemente del flujo de creación o edición

**Punto de control**: La historia 1 queda documentada y lista como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Crear y editar resúmenes de pago (Prioridad: P1)

**Objetivo**: Documentar la creación y edición de cabeceras de pago.

**Prueba independiente**: Crear un resumen, editarlo y comprobar que se conserva la estructura y la fecha formateada.

### Pruebas para la historia 2

- [x] T017 [P] [US2] Verificar la inicialización del componente en `PaymentresumeCreate::mount()`
- [x] T018 [P] [US2] Verificar la validación de `CreateForm` y la persistencia desde `PaymentresumeCreate::save()`
- [x] T019 [P] [US2] Verificar `PaymentresumeEdit::mount()` y la carga del formulario con contexto
- [x] T020 [P] [US2] Verificar `PaymentresumeEdit::save()` y la persistencia de cambios

### Implementación para la historia 2

- [x] T021 [P] [US2] Documentar el flujo de creación en `app/Livewire/Paymentresume/PaymentresumeCreate.php`
- [x] T022 [P] [US2] Documentar el flujo de edición en `app/Livewire/Paymentresume/PaymentresumeEdit.php`
- [x] T023 [US2] Mantener la redirección a la edición del resumen tras guardar desde Livewire
- [x] T024 [US2] Mantener la persistencia del campo de documento opcional
- [x] T025 [US2] Confirmar que la historia queda acotada al flujo administrativo y no rompe el listado

**Punto de control**: La historia 2 queda completa y es el núcleo operativo de resúmenes de pago.

---

## Fase 5: Historia de usuario 3 - Gestionar pagos asociados y enviar el detalle por email (Prioridad: P2)

**Objetivo**: Documentar el detalle de pagos asociados y el envío del resumen por email.

**Prueba independiente**: Abrir un resumen, añadir o editar pagos asociados y enviar el detalle por email.

### Pruebas para la historia 3

- [x] T026 [P] [US3] Verificar `PaymentresumePaymentsDetail::getRowsQueryProperty()` y su filtrado por descripción
- [x] T027 [P] [US3] Verificar `PaymentresumePaymentsDetail::save()` y `deletePayment()` sobre un pago asociado
- [x] T028 [P] [US3] Verificar `PaymentresumeEdit::print()` y el manejo del caso sin email

### Implementación para la historia 3

- [x] T029 [P] [US3] Documentar la vista `resources/views/livewire/payments/paymentresumes/payments-detail.blade.php`
- [x] T030 [P] [US3] Documentar la creación y edición modal de pagos desde `PaymentresumePaymentsDetail`
- [x] T031 [US3] Mantener la asociación del pago al `paymentresume_id` actual antes de guardar
- [x] T032 [US3] Mantener el envío de `App\Mail\PaymentresumeDetail` al usuario autenticado
- [x] T033 [US3] Confirmar que la historia no rompe el resto del flujo de Paymentresume

**Punto de control**: La historia 3 queda documentada como la capa operativa complementaria.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T034 [P] Documentar que no se añadieron nuevas dependencias ni servicios externos para esta migración
- [x] T035 [P] Documentar que la cobertura de pruebas es inexistente o no se detectó en el módulo Paymentresume
- [x] T036 Revisar que no se introducen conflictos con autenticación, permisos ni middleware existente
- [x] T037 Revisar consistencia entre componentes Livewire, formularios, modelo y vistas Blade del módulo
- [x] T038 Registrar que existen oportunidades de ampliar pruebas para email, detalle y CRUD de resúmenes
- [x] T039 Marcar la feature como migrada con gap de cobertura, no como feature nueva

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende de las demás
- **Historia 2**: proporciona los resúmenes que luego se detallan y envían por email
- **Historia 3**: depende del resumen ya existente, pero sigue siendo independiente en la práctica

### Dentro de cada historia

- Las pruebas van antes que la implementación documental correspondiente
- Los modelos y relaciones se documentan antes que las operaciones que dependen de ellos
- La autorización y validación se mantienen antes de las acciones de persistencia o notificación

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010 y T011 se pueden revisar en paralelo
- T017, T018, T019 y T020 se pueden revisar en paralelo
- T026, T027 y T028 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Consolidar Historia 2 porque es donde se crean y editan resúmenes.
3. Validar Historia 1 como consulta del listado.
4. Validar Historia 3 como capa operativa complementaria.

### Entrega incremental

1. Base documental del módulo.
2. Listado y búsqueda de resúmenes.
3. Creación y edición de cabeceras.
4. Detalle de pagos asociados y email.

### Estrategia de equipo

1. Una persona revisa el listado y las rutas.
2. Otra persona revisa creación y edición.
3. Otra persona revisa detalle, email y documentación de pruebas.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La cobertura detectada es limitada o ausente y conviene ampliarla si se quiere cerrar más comportamiento operativo.