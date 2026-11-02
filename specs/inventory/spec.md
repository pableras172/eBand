# Especificación de la Feature: Inventory

**Feature Branch**: `[inventory]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/Inventory/`, `app/Models/InventoryItem.php`, `app/Models/InventoryCategory.php`, `app/Models/InventoryMovement.php`, `app/Http/Controllers/InventoryExportController.php`, `routes/web.php` y `resources/views/livewire/inventory/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Consultar inventario con filtros operativos (Prioridad: P1)

Como usuario autorizado, quiero ver el inventario filtrado por año, categoría, estado y texto para localizar rápidamente los bienes y equipos relevantes.

**Por qué esta prioridad**: el listado es la puerta de entrada del módulo y concentra la consulta operativa diaria.

**Prueba independiente**: abrir el listado de inventario, aplicar filtros y comprobar que la paginación, la búsqueda y la visibilidad por rol funcionan como se espera.

**Escenarios de aceptación**:

1. **Dado** que accedo al listado de inventario, **cuando** la vista se renderiza, **entonces** se muestran los ítems filtrados según el año seleccionado y el rol del usuario.
2. **Dado** que aplico un filtro por categoría o estado, **cuando** se refresca la lista, **entonces** solo aparecen los ítems que coinciden con los criterios.
3. **Dado** que escribo un texto en la búsqueda, **cuando** se actualiza el listado, **entonces** se muestran solo los ítems cuyo nombre u observaciones coinciden.

---

### Historia de usuario 2 - Crear y editar ítems de inventario con responsables (Prioridad: P1)

Como usuario autorizado, quiero crear y editar ítems de inventario con categoría, valor, estado y responsables para mantener actualizado el patrimonio de la banda.

**Por qué esta prioridad**: la creación y edición son el flujo central del módulo y generan los movimientos operativos asociados.

**Prueba independiente**: crear un ítem válido con responsables, editarlo y comprobar que el sistema persiste los cambios y registra el movimiento correspondiente.

**Escenarios de aceptación**:

1. **Dado** que abro la pantalla de creación, **cuando** se monta el componente, **entonces** se cargan los usuarios disponibles según permisos.
2. **Dado** que relleno categoría, nombre, cantidad, valor y estado válidos, **cuando** guardo, **entonces** el ítem se crea con el año actual.
3. **Dado** que asigno responsables, **cuando** se guarda el ítem, **entonces** la relación se crea correctamente.
4. **Dado** que edito un ítem existente, **cuando** guardo los cambios, **entonces** se actualiza el inventario y se registra un movimiento de actualización.

---

### Historia de usuario 3 - Consultar detalle, estadísticas y exportaciones del inventario (Prioridad: P2)

Como usuario autorizado, quiero ver el detalle de un ítem, consultar estadísticas del inventario y exportar la información a Excel o PDF para análisis y reportes.

**Por qué esta prioridad**: completa el uso operativo del inventario y soporta decisiones y reportes del equipo.

**Prueba independiente**: abrir el detalle de un ítem, revisar estadísticas por categoría y ejecutar una exportación con y sin filtro de año.

**Escenarios de aceptación**:

1. **Dado** que abro el detalle de un ítem, **cuando** se renderiza la vista, **entonces** se cargan categoría, responsables y movimientos asociados.
2. **Dado** que accedo a estadísticas como administrador, **cuando** se calculan los datos, **entonces** veo el valor total y el reparto por categoría.
3. **Dado** que solicito una exportación Excel o PDF, **cuando** el usuario tiene permisos, **entonces** se genera el archivo con los ítems del año seleccionado o del inventario completo.

### Casos límite

- ¿Qué ocurre si el usuario no tiene permisos para ver o gestionar inventario?
- ¿Qué ocurre si se intenta editar un ítem inexistente?
- ¿Qué ocurre si una categoría no existe al crear o editar?
- ¿Qué ocurre si la exportación se solicita sin año o con un año sin ítems?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir consultar el inventario con paginación y filtros por año, categoría, estado y búsqueda.
- **FR-002**: El sistema debe limitar la visibilidad del inventario a los usuarios autorizados y, si no son administradores, a los ítems con responsables relacionados.
- **FR-003**: El sistema debe permitir crear ítems de inventario con categoría, nombre, cantidad, valor, estado y responsables opcionales.
- **FR-004**: El sistema debe validar los campos obligatorios y los rangos válidos antes de guardar un ítem.
- **FR-005**: El sistema debe crear un movimiento de inventario al registrar un ítem nuevo.
- **FR-006**: El sistema debe permitir editar ítems de inventario existentes y sincronizar sus responsables.
- **FR-007**: El sistema debe crear un movimiento de actualización al guardar cambios sobre un ítem.
- **FR-008**: El sistema debe permitir consultar el detalle de un ítem con sus relaciones cargadas.
- **FR-009**: El sistema debe calcular el valor total y el valor residual de un ítem a partir de sus atributos.
- **FR-010**: El sistema debe mostrar estadísticas agregadas por categoría y valor total del inventario.
- **FR-011**: El sistema debe permitir exportar el inventario a Excel y PDF con o sin filtro de año.
- **FR-012**: El sistema debe restringir las exportaciones a usuarios autorizados para crear ítems.
- **FR-013**: El sistema debe mantener compatibilidad con las vistas Livewire, Blade y la exportación existentes del módulo.

### Superficie Laravel / Livewire

- **Rutas**: `routes/web.php` contiene `inventory.index`, `inventory.create`, `inventory.edit`, `inventory.export.excel` y `inventory.export.pdf`.
- **Livewire**: `app/Livewire/Inventory/InventoryIndex.php`, `InventoryCreate.php`, `InventoryEdit.php`, `InventoryShow.php` y `InventoryStats.php` controlan el comportamiento principal.
- **Vistas**: `resources/views/livewire/inventory/inventory-index.blade.php`, `inventory-create.blade.php`, `inventory-edit.blade.php`, `inventory-show.blade.php` y `inventory-stats.blade.php` forman la interfaz visible.
- **Modelo**: `InventoryItem` centraliza el bien inventariado, sus valores y sus relaciones.
- **Relaciones**: `InventoryCategory`, `InventoryMovement` y `User` participan en la persistencia y el historial operativo.
- **Exportación**: `InventoryExportController` genera las salidas Excel y PDF.

### Entidades clave

- **InventoryItem**: representa un ítem del inventario con categoría, año, valores y estado.
- **InventoryCategory**: clasifica los ítems por tipo o familia.
- **InventoryMovement**: registra altas y actualizaciones operativas del inventario.
- **User**: actúa como responsable del ítem y como autor de movimientos.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario autorizado puede abrir el inventario y filtrar ítems por año, categoría, estado y búsqueda.
- **SC-002**: Un usuario con permisos puede crear un ítem válido con responsables y ver un movimiento inicial registrado.
- **SC-003**: Un usuario autorizado puede editar un ítem y comprobar que los responsables se sincronizan y se registra el cambio.
- **SC-004**: Un usuario autorizado puede abrir el detalle de un ítem y ver relaciones cargadas sin romper el contexto.
- **SC-005**: Un administrador puede consultar estadísticas agregadas y ver el valor total del inventario.
- **SC-006**: Un usuario autorizado puede exportar inventario a Excel o PDF con o sin filtro de año.
- **SC-007**: Las vistas existentes del módulo siguen funcionando sin romper la navegación ni las relaciones entre datos.

## Suposiciones

- Se reutiliza la autenticación y autorización existente de Laravel.
- El módulo mantiene la estructura monolítica actual y no se extrae a un servicio separado.
- La exportación se considera parte del comportamiento existente y no de un flujo nuevo.
- La cobertura de pruebas del módulo parece inexistente, así que esta migración documenta comportamiento observado, no validado por tests dedicados.