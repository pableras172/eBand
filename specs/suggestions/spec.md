# Especificación de la Feature: Suggestions

**Feature Branch**: `[suggestions]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/Suggestions/`, `app/Models/Suggestion.php`, `app/Livewire/Dashboard/Suggestions/Forms/`, `routes/web.php` y `resources/views/livewire/suggestions/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Consultar mis sugerencias y eliminarlas (Prioridad: P1)

Como usuario autenticado, quiero ver mis sugerencias, buscarlas por texto y eliminarlas para gestionar mis aportaciones desde un único lugar.

**Por qué esta prioridad**: el listado es el punto de entrada del módulo y permite al usuario revisar su propio contenido.

**Prueba independiente**: abrir el listado de sugerencias, aplicar búsqueda y eliminar una sugerencia propia.

**Escenarios de aceptación**:

1. **Dado** que accedo al listado de sugerencias, **cuando** la vista se renderiza, **entonces** se muestran solo mis sugerencias si no soy administrador.
2. **Dado** que escribo un término en la búsqueda, **cuando** se refresca la lista, **entonces** solo aparecen sugerencias cuyo título o texto coinciden.
3. **Dado** que confirmo una eliminación, **cuando** se ejecuta la acción, **entonces** la sugerencia desaparece del listado.

---

### Historia de usuario 2 - Crear sugerencias con o sin anonimato (Prioridad: P1)

Como usuario autenticado, quiero crear sugerencias con título, texto y opción anónima para aportar ideas sin exponer siempre mi identidad.

**Por qué esta prioridad**: la creación es el flujo central del módulo y registra la fecha y el autor de la sugerencia.

**Prueba independiente**: crear una sugerencia válida, con y sin anonimato, y comprobar que la fecha y el usuario se guardan correctamente.

**Escenarios de aceptación**:

1. **Dado** que abro la pantalla de creación, **cuando** se monta el componente, **entonces** la fecha de creación se rellena automáticamente y el usuario actual queda asignado.
2. **Dado** que relleno título y texto válidos, **cuando** guardo, **entonces** la sugerencia se crea con éxito.
3. **Dado** que activo la opción anónima, **cuando** se crea la sugerencia, **entonces** se guarda marcada como anónima.

---

### Historia de usuario 3 - Editar sugerencias y moderarlas como administrador (Prioridad: P2)

Como usuario autorizado, quiero editar mis sugerencias y, como administrador, añadir observaciones para moderarlas y mantener trazabilidad operativa.

**Por qué esta prioridad**: completa el ciclo de seguimiento de sugerencias y da soporte a la moderación administrativa.

**Prueba independiente**: abrir una sugerencia existente, editarla y comprobar que un administrador puede completar observaciones.

**Escenarios de aceptación**:

1. **Dado** que abro una sugerencia existente, **cuando** se carga el formulario, **entonces** veo el título, el texto, la fecha y el estado anónimo.
2. **Dado** que edito una sugerencia con datos válidos, **cuando** guardo, **entonces** los cambios se persisten y se emite el evento `saved`.
3. **Dado** que soy administrador, **cuando** edito una sugerencia, **entonces** puedo completar el campo de observaciones.

### Casos límite

- ¿Qué ocurre si el usuario no tiene permisos para crear, editar o eliminar sugerencias?
- ¿Qué ocurre si se intenta editar una sugerencia inexistente?
- ¿Qué ocurre si el texto o el título están vacíos?
- ¿Qué ocurre si un usuario no administrador intenta modificar observaciones?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir consultar sugerencias con paginación, búsqueda y ordenación.
- **FR-002**: El sistema debe limitar el listado a las sugerencias del usuario autenticado cuando no sea administrador.
- **FR-003**: El sistema debe permitir crear sugerencias con fecha, título, texto, observaciones opcionales y opción anónima.
- **FR-004**: El sistema debe asignar automáticamente el usuario autenticado como autor de la sugerencia al crear.
- **FR-005**: El sistema debe permitir editar sugerencias existentes.
- **FR-006**: El sistema debe permitir borrar sugerencias autorizadas desde el listado.
- **FR-007**: El sistema debe permitir que un administrador gestione observaciones sobre una sugerencia.
- **FR-008**: El sistema debe mantener compatibilidad con las vistas Livewire y Blade existentes del módulo.

### Superficie Laravel / Livewire

- **Rutas**: `routes/web.php` contiene `suggestions.index`, `suggestions.create` y `suggestions.edit`.
- **Livewire**: `app/Livewire/Suggestions/SuggestionIndex.php`, `SuggestionCreate.php` y `SuggestionEdit.php` controlan el comportamiento principal.
- **Vistas**: `resources/views/livewire/suggestions/index.blade.php`, `create.blade.php` y `edit.blade.php` forman la interfaz visible.
- **Formularios**: `app/Livewire/Dashboard/Suggestions/Forms/CreateForm.php` y `UpdateForm.php` encapsulan la validación y persistencia.
- **Modelo**: `Suggestion` centraliza la sugerencia, su autor, la fecha y el estado anónimo.

### Entidades clave

- **Suggestion**: representa una propuesta enviada por un usuario.
- **User**: autor de la sugerencia y responsable de su visibilidad.
- **Observaciones**: campo de moderación y seguimiento visible para administradores.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario autenticado puede abrir el listado de sugerencias y navegarlo con búsqueda y paginación.
- **SC-002**: Un usuario no administrador solo ve sus propias sugerencias.
- **SC-003**: Un usuario autenticado puede crear una sugerencia válida con o sin anonimato.
- **SC-004**: Un usuario autorizado puede editar una sugerencia existente y volver al listado sin romper el contexto.
- **SC-005**: Un administrador puede completar observaciones sobre una sugerencia.
- **SC-006**: Un usuario autorizado puede eliminar una sugerencia y verla desaparecer del listado.
- **SC-007**: Las vistas existentes del módulo siguen funcionando sin romper la navegación ni las relaciones entre datos.

## Suposiciones

- Se reutiliza la autenticación y autorización existente de Laravel.
- El módulo mantiene la estructura monolítica actual y no se extrae a un servicio separado.
- La visibilidad por usuario y el modo anónimo forman parte del comportamiento existente.
- La cobertura de pruebas del módulo parece inexistente, así que esta migración documenta comportamiento observado, no validado por tests dedicados.