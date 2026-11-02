# Especificación de la Feature: Comments

**Feature Branch**: `[comments]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/Comments/`, `app/Models/Comment.php`, `routes/web.php` y `resources/views/livewire/comments/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Consultar y moderar comentarios existentes (Prioridad: P1)

Como usuario autorizado, quiero ver el listado de comentarios, buscar por texto o usuario, y marcar comentarios como eliminados o inadecuados para moderar la conversación.

**Por qué esta prioridad**: el listado es el punto de entrada operativo del módulo y concentra la moderación diaria.

**Prueba independiente**: abrir el listado de comentarios, aplicar búsqueda, marcar un comentario como eliminado y denunciar otro como inadecuado.

**Escenarios de aceptación**:

1. **Dado** que accedo al listado de comentarios, **cuando** la vista se renderiza, **entonces** se muestran los comentarios con usuario asociado y ordenación actual.
2. **Dado** que escribo un término en la búsqueda, **cuando** se refresca la lista, **entonces** solo aparecen comentarios o usuarios coincidentes.
3. **Dado** que confirmo una eliminación, **cuando** se ejecuta la acción, **entonces** el comentario alterna su estado `eliminado`.
4. **Dado** que confirmo una denuncia, **cuando** se ejecuta la acción, **entonces** el comentario alterna su estado `inadecuado`.

---

### Historia de usuario 2 - Crear comentarios asociados a actuaciones (Prioridad: P1)

Como usuario autenticado, quiero crear comentarios vinculados a una actuación para registrar aportaciones o incidencias sobre ese evento.

**Por qué esta prioridad**: la alta de comentarios alimenta el flujo operativo de la aplicación y conecta la conversación con una actuación concreta.

**Prueba independiente**: crear un comentario válido desde el formulario y comprobar que queda asociado al usuario autenticado y a la actuación indicada.

**Escenarios de aceptación**:

1. **Dado** que abro la pantalla de creación, **cuando** se monta el componente, **entonces** se prepara la estructura del formulario.
2. **Dado** que relleno comentario, usuario y actuación válidos, **cuando** guardo, **entonces** el comentario se persiste correctamente.
3. **Dado** que envío la creación por la ruta JSON manual, **cuando** los datos son válidos, **entonces** el sistema devuelve una respuesta JSON de éxito.

---

### Historia de usuario 3 - Editar comentarios y revisar contexto operativo (Prioridad: P2)

Como usuario autorizado, quiero editar un comentario existente para corregir su texto, revisar su estado y mantener su trazabilidad con la actuación asociada.

**Por qué esta prioridad**: completa el ciclo de moderación y mantenimiento del contenido del comentario.

**Prueba independiente**: abrir un comentario existente, modificarlo y comprobar que el formulario conserva usuario, fecha, actuación y estados de moderación.

**Escenarios de aceptación**:

1. **Dado** que abro un comentario existente, **cuando** se carga el formulario, **entonces** veo el texto, el usuario, la actuación y los estados actuales.
2. **Dado** que actualizo el comentario, **cuando** guardo, **entonces** se persisten los cambios y vuelvo al listado.
3. **Dado** que reviso los flags operativos, **cuando** el formulario se renderiza, **entonces** aparecen los estados `eliminado` e `inadecuado`.

### Casos límite

- ¿Qué ocurre si el usuario no tiene permisos para crear o editar comentarios?
- ¿Qué ocurre si se intenta editar un comentario inexistente?
- ¿Qué ocurre si la actuación asociada no existe o no es válida?
- ¿Qué ocurre si el comentario supera el tamaño permitido en la creación manual JSON?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir consultar comentarios con paginación y búsqueda por comentario o nombre de usuario.
- **FR-002**: El sistema debe permitir alternar el estado `eliminado` de un comentario desde el listado.
- **FR-003**: El sistema debe permitir alternar el estado `inadecuado` para denunciar un comentario.
- **FR-004**: El sistema debe permitir crear comentarios vinculados a una actuación y al usuario autenticado.
- **FR-005**: El sistema debe validar los campos obligatorios antes de guardar un comentario.
- **FR-006**: El sistema debe permitir editar comentarios existentes y conservar su contexto operativo.
- **FR-007**: El sistema debe mantener la asociación del comentario con la actuación y el usuario.
- **FR-008**: El sistema debe ofrecer una respuesta JSON de creación cuando la ruta manual la utilice.
- **FR-009**: El sistema debe mantener compatibilidad con las vistas Livewire y Blade existentes del módulo.

### Superficie Laravel / Livewire

- **Rutas**: `routes/web.php` contiene `comments.index`, `comments.create` y `comments.edit`.
- **Livewire**: `app/Livewire/Comments/CommentIndex.php`, `CommentCreate.php` y `CommentEdit.php` controlan el comportamiento principal.
- **Vistas**: `resources/views/livewire/comments/index.blade.php`, `create.blade.php` y `edit.blade.php` forman la interfaz visible.
- **Formularios**: `app/Livewire/Dashboard/Comments/Forms/CreateForm.php` y `UpdateForm.php` encapsulan parte de la validación y persistencia.
- **Modelo**: `Comment` centraliza el comentario, el usuario, la actuación y los flags operativos.

### Entidades clave

- **Comment**: representa un comentario asociado a una actuación y a un usuario.
- **User**: autor o propietario del comentario.
- **Actuacion**: contexto operativo al que pertenece el comentario.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario autorizado puede abrir el listado de comentarios y navegarlo con búsqueda y paginación.
- **SC-002**: Un moderador puede marcar comentarios como eliminados o inadecuados desde la interfaz.
- **SC-003**: Un usuario autenticado puede crear un comentario válido asociado a una actuación.
- **SC-004**: Un usuario autorizado puede editar un comentario existente y volver al listado sin romper el contexto.
- **SC-005**: La ruta de creación manual devuelve una respuesta JSON comprensible cuando los datos son válidos.
- **SC-006**: Las vistas existentes del módulo siguen funcionando sin romper la navegación ni las relaciones entre datos.

## Suposiciones

- Se reutiliza la autenticación y autorización existente de Laravel.
- El módulo mantiene la estructura monolítica actual y no se extrae a un servicio separado.
- La moderación de comentarios se implementa como alternancia de flags, no como borrado físico.
- La cobertura de pruebas del módulo parece inexistente, así que esta migración documenta comportamiento observado, no validado por tests dedicados.