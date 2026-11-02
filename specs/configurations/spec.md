# Especificación de la Feature: Configuration

**Feature Branch**: `[configurations]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/Configuration/`, `app/Livewire/Dashboard/Configurations/Forms/`, `app/Models/Configuration.php`, `routes/web.php` y `resources/views/livewire/configurations/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Consultar, buscar y eliminar configuraciones existentes (Prioridad: P1)

Como usuario autorizado, quiero ver el listado de configuraciones, buscar por parámetro y eliminar entradas para mantener limpios los ajustes del sistema.

**Por qué esta prioridad**: el listado es la puerta de entrada del módulo y concentra la administración diaria de parámetros.

**Prueba independiente**: abrir el listado de configuraciones, aplicar búsqueda, ordenar resultados y eliminar una configuración autorizada.

**Escenarios de aceptación**:

1. **Dado** que accedo al listado de configuraciones, **cuando** la vista se renderiza, **entonces** se muestran las entradas ordenadas según el criterio actual.
2. **Dado** que escribo un término en la búsqueda, **cuando** se refresca la lista, **entonces** solo aparecen configuraciones cuyo parámetro coincide.
3. **Dado** que confirmo una eliminación, **cuando** se ejecuta la acción, **entonces** la configuración desaparece y el sistema refresca el caché de ajustes.

---

### Historia de usuario 2 - Crear configuraciones con parámetro y valor válidos (Prioridad: P1)

Como administrador, quiero crear configuraciones nuevas con un parámetro único y un valor obligatorio para ampliar los ajustes del sistema.

**Por qué esta prioridad**: la creación es el flujo central del módulo y activa la lógica de refresco de configuración compartida.

**Prueba independiente**: crear una configuración válida y comprobar que se persiste correctamente y que el helper de configuración se refresca.

**Escenarios de aceptación**:

1. **Dado** que abro la pantalla de creación, **cuando** se monta el componente, **entonces** se muestra el formulario vacío para introducir parámetro y valor.
2. **Dado** que relleno `param` y `value` válidos, **cuando** guardo, **entonces** la configuración se crea con éxito.
3. **Dado** que intento crear un parámetro duplicado, **cuando** guardo, **entonces** el sistema rechaza la operación por unicidad.

---

### Historia de usuario 3 - Editar configuraciones existentes y conservar la coherencia del sistema (Prioridad: P2)

Como administrador, quiero editar una configuración existente para corregir el parámetro o el valor sin romper la coherencia del sistema.

**Por qué esta prioridad**: completa el ciclo de mantenimiento de parámetros y mantiene actualizados los ajustes efectivos.

**Prueba independiente**: abrir una configuración existente, modificarla y comprobar que el sistema conserva la unicidad del parámetro y refresca la configuración en memoria.

**Escenarios de aceptación**:

1. **Dado** que abro una configuración existente, **cuando** se carga el formulario, **entonces** veo el parámetro y el valor actuales.
2. **Dado** que actualizo una configuración con datos válidos, **cuando** guardo, **entonces** se persisten los cambios y se refrescan los ajustes.
3. **Dado** que cambio el parámetro a uno ya existente, **cuando** guardo, **entonces** la validación de unicidad evita el guardado.

### Casos límite

- ¿Qué ocurre si el usuario no tiene permisos para crear, editar o eliminar configuraciones?
- ¿Qué ocurre si se intenta editar una configuración inexistente?
- ¿Qué ocurre si el parámetro ya existe en otra fila?
- ¿Qué ocurre si el helper de recarga falla al guardar o borrar?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir consultar configuraciones con paginación, búsqueda y ordenación.
- **FR-002**: El sistema debe permitir eliminar configuraciones autorizadas desde el listado.
- **FR-003**: El sistema debe permitir crear configuraciones con `param` y `value` obligatorios.
- **FR-004**: El sistema debe garantizar la unicidad del parámetro al crear o editar una configuración.
- **FR-005**: El sistema debe permitir editar configuraciones existentes.
- **FR-006**: El sistema debe refrescar la configuración en memoria o caché al guardar o borrar una entrada.
- **FR-007**: El sistema debe mantener compatibilidad con las vistas Livewire y Blade existentes del módulo.

### Superficie Laravel / Livewire

- **Rutas**: `routes/web.php` contiene `configurations.index`, `configurations.create` y `configurations.edit`.
- **Livewire**: `app/Livewire/Configuration/ConfigurationIndex.php`, `ConfigurationCreate.php` y `ConfigurationEdit.php` controlan el comportamiento principal.
- **Vistas**: `resources/views/livewire/configurations/index.blade.php`, `create.blade.php` y `edit.blade.php` forman la interfaz visible.
- **Formularios**: `app/Livewire/Dashboard/Configurations/Forms/CreateForm.php` y `UpdateForm.php` encapsulan la validación y persistencia.
- **Modelo**: `Configuration` centraliza el parámetro, el valor y el refresco posterior mediante `ConfigHelper`.

### Entidades clave

- **Configuration**: representa un parámetro del sistema con su valor y ayuda opcional.
- **ConfigHelper**: refresca la configuración consumida por la aplicación tras cambios en la tabla.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario autorizado puede abrir el listado de configuraciones y navegarlo con búsqueda y paginación.
- **SC-002**: Un administrador puede crear una configuración válida con parámetro único y valor obligatorio.
- **SC-003**: El sistema rechaza parámetros duplicados al crear o editar.
- **SC-004**: Un usuario autorizado puede editar una configuración existente y volver al listado sin romper el contexto.
- **SC-005**: Al guardar o eliminar una configuración, el helper de recarga se ejecuta para mantener coherencia.
- **SC-006**: Las vistas existentes del módulo siguen funcionando sin romper la navegación ni las relaciones entre datos.

## Suposiciones

- Se reutiliza la autenticación y autorización existente de Laravel.
- El módulo mantiene la estructura monolítica actual y no se extrae a un servicio separado.
- La recarga de configuración se considera parte del comportamiento existente y no de un flujo nuevo.
- La cobertura de pruebas del módulo parece inexistente, así que esta migración documenta comportamiento observado, no validado por tests dedicados.