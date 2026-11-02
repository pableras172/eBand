# Especificación de la Feature: Announcements

**Feature Branch**: `[announcements]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/Announcement/`, `app/Models/Announcement.php`, `routes/web.php` y `resources/views/livewire/announcement/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Consultar, gestionar y notificar anuncios existentes (Prioridad: P1)

Como usuario autorizado, quiero ver el listado de anuncios, buscar por texto, eliminar anuncios y notificar a los usuarios objetivo para gestionar las comunicaciones de la banda desde un único lugar.

**Por qué esta prioridad**: el listado centraliza el ciclo de vida operativo del anuncio y es el punto de entrada principal del módulo.

**Prueba independiente**: abrir el listado de anuncios, aplicar búsqueda, eliminar un anuncio autorizado y lanzar la notificación a usuarios objetivo.

**Escenarios de aceptación**:

1. **Dado** que accedo al listado de anuncios, **cuando** la vista se renderiza, **entonces** se muestran los anuncios con métricas y relaciones cargadas.
2. **Dado** que escribo un término en la búsqueda, **cuando** se refresca el listado, **entonces** solo aparecen anuncios cuyo título o cuerpo coinciden.
3. **Dado** que solicito eliminar un anuncio, **cuando** confirmo la acción, **entonces** el anuncio se borra y desaparece del listado.
4. **Dado** que notifico un anuncio válido, **cuando** se ejecuta la acción, **entonces** se envían notificaciones a los usuarios objetivo y se guarda la fecha de notificación.

---

### Historia de usuario 2 - Crear anuncios con reglas de destino y contenido opcional (Prioridad: P1)

Como administrador, quiero crear anuncios con texto, vista personalizada, redirección y selección de instrumentos para comunicar información relevante a los destinatarios correctos.

**Por qué esta prioridad**: la creación define el contenido y el alcance del anuncio, que después usa el popup y la notificación.

**Prueba independiente**: crear un anuncio con datos válidos, comprobar que queda activo en su ventana temporal y que se asocia a todos los usuarios o a instrumentos concretos según la selección.

**Escenarios de aceptación**:

1. **Dado** que soy administrador, **cuando** abro la pantalla de creación, **entonces** el formulario prepara la fecha de inicio con el valor actual.
2. **Dado** que indico título, cuerpo o vista personalizada y fechas válidas, **cuando** guardo el anuncio, **entonces** se persiste correctamente.
3. **Dado** que desmarco “Todos” y no selecciono instrumentos, **cuando** intento guardar, **entonces** se muestra un error de validación comprensible.
4. **Dado** que creo un anuncio con instrumentos concretos, **cuando** se guarda, **entonces** queda sincronizada la relación con esos instrumentos.

---

### Historia de usuario 3 - Editar anuncios y mostrar popup visible para usuarios autenticados (Prioridad: P2)

Como usuario autorizado, quiero editar un anuncio y que los usuarios vean un popup con el anuncio activo que les corresponde para mantener la comunicación operativa al día.

**Por qué esta prioridad**: completa el ciclo del anuncio desde su edición hasta su consumo en la interfaz pública o privada.

**Prueba independiente**: abrir un anuncio existente, editarlo y comprobar que el popup recupera el anuncio activo correspondiente para el usuario autenticado.

**Escenarios de aceptación**:

1. **Dado** que abro un anuncio existente, **cuando** se carga el formulario, **entonces** veo sus datos, fechas y destino actual.
2. **Dado** que actualizo el anuncio con datos válidos, **cuando** guardo, **entonces** se persisten los cambios y se sincronizan los instrumentos.
3. **Dado** que un usuario autenticado tiene un anuncio visible para él, **cuando** se monta el popup, **entonces** se muestra el anuncio más reciente dentro de su ventana activa.
4. **Dado** que un anuncio tiene una vista personalizada válida o una URL de redirección, **cuando** el usuario lo marca como leído o cerrado, **entonces** se registra el estado y, si aplica, se redirige.

### Casos límite

- ¿Qué ocurre si el usuario no tiene permisos para crear, editar o eliminar anuncios?
- ¿Qué ocurre si se intenta notificar un anuncio que no está en ventana activa?
- ¿Qué ocurre si un anuncio no tiene contenido válido ni vista personalizada?
- ¿Qué ocurre si el usuario no tiene instrumento asociado y el anuncio no aplica a todos?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir consultar anuncios con paginación y búsqueda por título o cuerpo.
- **FR-002**: El sistema debe permitir eliminar anuncios autorizados desde el listado.
- **FR-003**: El sistema debe permitir notificar anuncios a los usuarios objetivo y registrar la fecha de notificación.
- **FR-004**: El sistema debe permitir crear anuncios con título, cuerpo o vista personalizada, redirección y fechas.
- **FR-005**: El sistema debe validar que exista contenido válido cuando no se usa vista personalizada.
- **FR-006**: El sistema debe permitir marcar un anuncio para todos los usuarios o para instrumentos concretos.
- **FR-007**: El sistema debe impedir guardar anuncios sin instrumentos cuando no aplican a todos.
- **FR-008**: El sistema debe permitir editar anuncios existentes y sincronizar sus instrumentos.
- **FR-009**: El sistema debe mostrar un popup con el anuncio visible más reciente para el usuario autenticado.
- **FR-010**: El sistema debe registrar si un anuncio fue leído o cerrado por el usuario.
- **FR-011**: El sistema debe redirigir al usuario cuando el anuncio tenga `redirect_url` y se marque como leído.
- **FR-012**: El sistema debe mantener compatibilidad con las vistas Livewire y Blade existentes del módulo.

### Superficie Laravel / Livewire

- **Rutas**: `routes/web.php` contiene `announcements.index`, `announcements.create` y `announcements.edit`.
- **Livewire**: `app/Livewire/Announcement/AnnouncementIndex.php`, `AnnouncementCreate.php`, `AnnouncementEdit.php`, `AnnouncementPopup.php` y `AnnouncementHighlights.php` participan en el módulo.
- **Vistas**: `resources/views/livewire/announcement/announcement-index.blade.php`, `announcement-create.blade.php`, `announcement-edit.blade.php`, `announcement-popup.blade.php` y `announcement-highlights.blade.php` forman la UI.
- **Modelo**: `Announcement` centraliza el estado, la ventana activa y la relación con instrumentos y estados.
- **Notificación**: `AnnouncementPublishedNotification` se usa para distribuir anuncios a usuarios objetivo.

### Entidades clave

- **Announcement**: representa un anuncio con texto, ventana temporal, visibilidad y alcance por instrumentos.
- **AnnouncementStatus**: registra si el anuncio fue visto o cerrado por un usuario.
- **Instrument**: define el alcance cuando el anuncio no aplica a todos.
- **User**: recibe el anuncio y determina la visibilidad del popup.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario autorizado puede listar, buscar y eliminar anuncios desde la interfaz Livewire.
- **SC-002**: Un administrador puede crear un anuncio válido con alcance global o por instrumentos.
- **SC-003**: El sistema notifica a los usuarios objetivo y actualiza la fecha de notificación del anuncio.
- **SC-004**: Un usuario autenticado ve el popup del anuncio activo que le corresponde.
- **SC-005**: El popup registra lectura o cierre y respeta la redirección cuando está definida.
- **SC-006**: Las vistas existentes del módulo siguen funcionando sin romper la navegación ni las relaciones entre datos.

## Suposiciones

- Se reutiliza la autenticación y autorización existente de Laravel.
- El módulo mantiene la estructura monolítica actual y no se extrae a un servicio separado.
- La distribución de anuncios por notificación y popup forma parte del comportamiento existente y no de un flujo nuevo.
- La cobertura de pruebas del módulo no se detectó, así que esta migración documenta comportamiento observado, no validado por tests dedicados.