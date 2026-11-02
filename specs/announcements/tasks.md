# Tareas: Announcements

**Entrada**: Documentos de diseño en `specs/announcements/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y toca comportamiento visible y operativo.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de implementación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar los puntos de entrada reales del módulo antes de documentar cada flujo.

- [x] T001 Confirmar el alcance del módulo en `app/Livewire/Announcement/`, `app/Models/Announcement.php` y `resources/views/livewire/announcement/`
- [x] T002 [P] Identificar las rutas afectadas en `routes/web.php` para listado, creación y edición de anuncios
- [x] T003 [P] Verificar la relación de `Announcement` con `AnnouncementStatus`, `Instrument` y `User`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el listado de anuncios usa paginación, búsqueda y relaciones cargadas en `AnnouncementIndex`
- [x] T005 [P] Revisar que la creación valida título, contenido, ventana temporal y destino en `AnnouncementCreate`
- [x] T006 [P] Revisar que la edición sincroniza instrumentos y conserva el estado del anuncio en `AnnouncementEdit`
- [x] T007 Revisar que el popup de usuario existe en `AnnouncementPopup` y usa el scope de visibilidad
- [x] T008 Revisar que la autorización protege las operaciones de listado, creación, edición, borrado y notificación
- [x] T009 Confirmar que el módulo se apoya en la estructura monolítica existente sin dependencias externas nuevas

**Punto de control**: La base está lista; el módulo ya existe y puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Consultar, gestionar y notificar anuncios existentes (Prioridad: P1)

**Objetivo**: Documentar el listado operativo de anuncios con búsqueda, borrado y envío a usuarios objetivo.

**Prueba independiente**: Abrir el listado de anuncios y comprobar que se pueden filtrar, eliminar y notificar registros autorizados.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar `AnnouncementIndex::render()` y su filtrado por título o cuerpo
- [x] T011 [P] [US1] Verificar `AnnouncementIndex::confirmDeletion()` y `delete()` sobre un anuncio existente
- [x] T012 [P] [US1] Verificar `AnnouncementIndex::notifyUsers()` y la actualización de `notified_at`

### Implementación para la historia 1

- [x] T013 [P] [US1] Mantener la acción `mount()` en `app/Livewire/Announcement/AnnouncementIndex.php` como punto de entrada del listado
- [x] T014 [P] [US1] Mantener la vista `resources/views/livewire/announcement/announcement-index.blade.php` como salida principal de listados
- [x] T015 [US1] Preservar la paginación, búsqueda y métricas derivadas del listado
- [x] T016 [US1] Mantener el borrado autorizado de anuncios desde el listado
- [x] T017 [US1] Mantener el envío de notificaciones a los usuarios objetivo con `AnnouncementPublishedNotification`
- [x] T018 [US1] Confirmar que la historia funciona independientemente del flujo de creación o edición

**Punto de control**: La historia 1 queda documentada y lista como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Crear anuncios con reglas de destino y contenido opcional (Prioridad: P1)

**Objetivo**: Documentar la creación de anuncios con contenido, vistas personalizadas y destino por instrumentos.

**Prueba independiente**: Crear un anuncio válido y comprobar que queda asociado a los instrumentos o a todos los usuarios según corresponda.

### Pruebas para la historia 2

- [x] T019 [P] [US2] Verificar la inicialización del formulario en `AnnouncementCreate::mount()`
- [x] T020 [P] [US2] Verificar que `rules()` exige contenido válido, fechas y destino correcto

### Implementación para la historia 2

- [x] T021 [P] [US2] Documentar el flujo de creación en `app/Livewire/Announcement/AnnouncementCreate.php`
- [x] T022 [P] [US2] Documentar la validación condicional de cuerpo o vista personalizada
- [x] T023 [US2] Documentar el guardado del anuncio con `created_by` y ventana temporal
- [x] T024 [US2] Mantener la sincronización de instrumentos al crear anuncios no globales
- [x] T025 [US2] Confirmar que la historia queda acotada al flujo administrativo y no rompe el listado

**Punto de control**: La historia 2 queda completa y es la base de la comunicación operativa del módulo.

---

## Fase 5: Historia de usuario 3 - Editar anuncios y mostrar popup visible para usuarios autenticados (Prioridad: P2)

**Objetivo**: Documentar la edición del anuncio y su consumo a través del popup visible para el usuario.

**Prueba independiente**: Abrir un anuncio existente, editarlo y comprobar que el popup recupera el anuncio activo correspondiente para el usuario autenticado.

### Pruebas para la historia 3

- [x] T026 [P] [US3] Verificar `AnnouncementEdit::save()` y la sincronización de instrumentos
- [x] T027 [P] [US3] Verificar `AnnouncementPopup::mount()` y la selección del anuncio visible
- [x] T028 [P] [US3] Verificar `AnnouncementPopup::markAsRead()` y `dismiss()` sobre `AnnouncementStatus`

### Implementación para la historia 3

- [x] T029 [P] [US3] Documentar la ruta de edición `app/Livewire/Announcement/AnnouncementEdit.php`
- [x] T030 [P] [US3] Documentar la persistencia de cambios y el refresco de instrumentos
- [x] T031 [US3] Documentar el popup de usuario en `app/Livewire/Announcement/AnnouncementPopup.php`
- [x] T032 [US3] Mantener el registro de leído/cerrado en `AnnouncementStatus`
- [x] T033 [US3] Mantener la redirección cuando el anuncio tiene `redirect_url`
- [x] T034 [US3] Confirmar que el popup no rompe el resto del flujo de Announcements

**Punto de control**: La historia 3 queda documentada como la capa visible para el usuario autenticado.

---

## Fase 6: Aspectos cruzados y highlights

**Objetivo**: Documentar el componente auxiliar de destacados y cerrar gaps de cobertura.

**Prueba independiente**: Verificar que el bloque de destacados y el popup siguen el mismo anuncio activo o visible.

### Pruebas para esta fase

- [x] T035 [P] Verificar que `AnnouncementHighlights` se alimenta de la misma fuente de anuncios activos
- [x] T036 [P] Verificar que no existen pruebas dedicadas al módulo y registrar el gap de cobertura

### Implementación para esta fase

- [x] T037 [P] Documentar la vista `resources/views/livewire/announcement/announcement-highlights.blade.php`
- [x] T038 [P] Documentar la coherencia entre popup, destacados y listado principal
- [x] T039 [P] Documentar la ausencia de cobertura de pruebas dedicada para el módulo
- [x] T040 Confirmar que el módulo no rompe autenticación, navegación ni el comportamiento de rutas existentes

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T041 [P] Documentar que no se añadieron nuevas dependencias ni servicios externos para esta migración
- [x] T042 [P] Documentar que la cobertura de pruebas es inexistente o no se detectó en el módulo Announcements
- [x] T043 Revisar que no se introducen conflictos con autenticación, permisos ni middleware existente
- [x] T044 Revisar consistencia entre componentes Livewire, modelo y vistas Blade del módulo
- [x] T045 Registrar que existen oportunidades de ampliar pruebas para notificaciones, popup y estados de lectura
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
- **Historia 2**: proporciona el contenido y el alcance que luego consumen el popup y la notificación
- **Historia 3**: depende de la existencia de anuncios válidos, pero sigue siendo independiente en la práctica

### Dentro de cada historia

- Las pruebas van antes que la implementación documental correspondiente
- Los modelos y relaciones se documentan antes que las operaciones que dependen de ellos
- La autorización y validación se mantienen antes de las acciones de persistencia o notificación

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010, T011 y T012 se pueden revisar en paralelo
- T019 y T020 se pueden revisar en paralelo
- T026, T027 y T028 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Consolidar Historia 2 porque es donde se define el alcance del anuncio.
3. Validar Historia 1 como consulta y gestión del listado.
4. Validar Historia 3 como capa visible para el usuario autenticado.
5. Cerrar el bloque de highlights como soporte visual complementario.

### Entrega incremental

1. Base documental del módulo.
2. Listado y notificación de anuncios.
3. Creación con destinos e ինտერვalo temporal.
4. Edición, popup y tracking de lectura/cierre.
5. Highlights y coherencia entre superficies.

### Estrategia de equipo

1. Una persona revisa el listado y las rutas.
2. Otra persona revisa creación, edición y popup.
3. Otra persona revisa notificación, estados y la documentación de pruebas.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La cobertura detectada es limitada o ausente y conviene ampliarla si se quiere cerrar más comportamiento operativo.