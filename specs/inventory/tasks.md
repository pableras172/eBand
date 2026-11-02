# Tareas: Inventory

**Entrada**: Documentos de diseño en `specs/inventory/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y toca comportamiento visible y operativo.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de implementación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar los puntos de entrada reales del módulo antes de documentar cada flujo.

- [x] T001 Confirmar el alcance del módulo en `app/Livewire/Inventory/`, `app/Models/InventoryItem.php`, `app/Models/InventoryCategory.php`, `app/Models/InventoryMovement.php` y `resources/views/livewire/inventory/`
- [x] T002 [P] Identificar las rutas afectadas en `routes/web.php` para listado, creación, edición, estadísticas y exportación de inventario
- [x] T003 [P] Verificar la relación de `InventoryItem` con `InventoryCategory`, `InventoryMovement` y `User`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el listado de inventario usa paginación, filtros y visibilidad por rol en `InventoryIndex`
- [x] T005 [P] Revisar que la creación valida categoría, nombre, cantidad, valor y estado en `InventoryCreate`
- [x] T006 [P] Revisar que la edición conserva el contexto del ítem, sincroniza responsables y registra un movimiento en `InventoryEdit`
- [x] T007 Revisar que el detalle carga relaciones y el cálculo de valor total y residual existe en el modelo
- [x] T008 Revisar que la autorización protege las operaciones de listado, creación, edición, detalle, estadísticas y exportación
- [x] T009 Confirmar que el módulo se apoya en la estructura monolítica existente sin dependencias externas nuevas

**Punto de control**: La base está lista; el módulo ya existe y puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Consultar inventario con filtros operativos (Prioridad: P1)

**Objetivo**: Documentar el listado operativo del inventario con filtros y visibilidad por rol.

**Prueba independiente**: Abrir el listado de inventario y comprobar que se puede filtrar por año, categoría, estado y texto.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar `InventoryIndex::filteredQuery()` y su filtrado por año, categoría, estado y búsqueda
- [x] T011 [P] [US1] Verificar la lógica de visibilidad por rol en `InventoryIndex::baseQuery()`

### Implementación para la historia 1

- [x] T012 [P] [US1] Mantener la acción `mount()` en `app/Livewire/Inventory/InventoryIndex.php` como punto de entrada del listado
- [x] T013 [P] [US1] Mantener la vista `resources/views/livewire/inventory/inventory-index.blade.php` como salida principal de listados
- [x] T014 [US1] Preservar la paginación, búsqueda y filtros por categoría, estado y año
- [x] T015 [US1] Mantener la restricción de visibilidad para no administradores según responsables
- [x] T016 [US1] Confirmar que la historia funciona independientemente del flujo de creación o edición

**Punto de control**: La historia 1 queda documentada y lista como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Crear y editar ítems de inventario con responsables (Prioridad: P1)

**Objetivo**: Documentar la creación y edición de ítems con responsables y movimiento operativo.

**Prueba independiente**: Crear un ítem con responsables, editarlo y comprobar que se guardan los cambios y el movimiento correspondiente.

### Pruebas para la historia 2

- [x] T017 [P] [US2] Verificar la inicialización del componente en `InventoryCreate::mount()`
- [x] T018 [P] [US2] Verificar la validación de `InventoryCreate::rules()` y la creación del movimiento de alta
- [x] T019 [P] [US2] Verificar `InventoryEdit::mount()` y la carga del contexto de edición
- [x] T020 [P] [US2] Verificar `InventoryEdit::save()` y la creación del movimiento de actualización

### Implementación para la historia 2

- [x] T021 [P] [US2] Documentar el flujo de creación en `app/Livewire/Inventory/InventoryCreate.php`
- [x] T022 [P] [US2] Documentar la persistencia del ítem y la asignación de responsables
- [x] T023 [US2] Mantener la redirección al listado tras crear o editar un ítem
- [x] T024 [US2] Documentar la sincronización de responsables al editar un ítem
- [x] T025 [US2] Confirmar que la historia queda acotada al flujo administrativo y no rompe el listado

**Punto de control**: La historia 2 queda completa y es el núcleo operativo del inventario.

---

## Fase 5: Historia de usuario 3 - Consultar detalle, estadísticas y exportaciones del inventario (Prioridad: P2)

**Objetivo**: Documentar el detalle, las estadísticas y las exportaciones del inventario.

**Prueba independiente**: Abrir el detalle de un ítem, consultar estadísticas y ejecutar exportaciones con y sin filtro de año.

### Pruebas para la historia 3

- [x] T026 [P] [US3] Verificar `InventoryShow::render()` y la carga de relaciones del ítem
- [x] T027 [P] [US3] Verificar `InventoryStats::getStatsData()` y el cálculo de totales por categoría
- [x] T028 [P] [US3] Verificar `InventoryExportController::excel()` y `pdf()` con autorización y filtro opcional de año

### Implementación para la historia 3

- [x] T029 [P] [US3] Documentar la ruta de detalle `app/Livewire/Inventory/InventoryShow.php`
- [x] T030 [P] [US3] Documentar la ruta de estadísticas `app/Livewire/Inventory/InventoryStats.php`
- [x] T031 [US3] Mantener el cálculo de valor total y valor residual en `InventoryItem`
- [x] T032 [US3] Mantener la exportación a Excel y PDF desde `InventoryExportController`
- [x] T033 [US3] Confirmar que la historia no rompe el resto del flujo de Inventory

**Punto de control**: La historia 3 queda documentada como la capa analítica y de reporte.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T034 [P] Documentar que no se añadieron nuevas dependencias ni servicios externos para esta migración
- [x] T035 [P] Documentar que la cobertura de pruebas es inexistente o no se detectó en el módulo Inventory
- [x] T036 Revisar que no se introducen conflictos con autenticación, permisos ni middleware existente
- [x] T037 Revisar consistencia entre componentes Livewire, modelos, controlador de exportación y vistas Blade del módulo
- [x] T038 Registrar que existen oportunidades de ampliar pruebas para filtros, exportaciones y visibilidad por rol
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
- **Historia 2**: proporciona los ítems y responsables que luego se consultan y editan
- **Historia 3**: depende del modelo de inventario ya poblado, pero sigue siendo independiente en la práctica

### Dentro de cada historia

- Las pruebas van antes que la implementación documental correspondiente
- Los modelos y relaciones se documentan antes que las operaciones que dependen de ellos
- La autorización y validación se mantienen antes de las acciones de persistencia, exportación o agregación

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010 y T011 se pueden revisar en paralelo
- T017 y T018 se pueden revisar en paralelo
- T026, T027 y T028 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Consolidar Historia 2 porque es donde se crean y actualizan ítems.
3. Validar Historia 1 como consulta del inventario.
4. Validar Historia 3 como capa analítica y de exportación.

### Entrega incremental

1. Base documental del módulo.
2. Listado filtrado y visibilidad por rol.
3. Creación y edición con responsables.
4. Detalle, estadísticas y exportaciones.

### Estrategia de equipo

1. Una persona revisa el listado y las rutas.
2. Otra persona revisa creación, edición y movimientos.
3. Otra persona revisa estadísticas, exportación y documentación de pruebas.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La cobertura detectada es limitada o ausente y conviene ampliarla si se quiere cerrar más comportamiento operativo.