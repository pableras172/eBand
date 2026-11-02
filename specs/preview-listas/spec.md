# Especificación de la Feature: Previsualización de listas

**Feature Branch**: `[preview-listas]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/PreviewListas.php` y `resources/views/livewire/preview-listas.blade.php`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Ver la previsualización de una lista de actuación (Prioridad: P1)

Como usuario de la aplicación, quiero abrir una previsualización de la lista asociada a una actuación para consultar quién está seleccionado, su disponibilidad y los datos básicos del evento.

**Por qué esta prioridad**: la vista modal es el comportamiento principal del módulo y da acceso a la información operativa de la lista.

**Prueba independiente**: abrir la previsualización de una actuación y verificar que aparecen los datos del evento, los usuarios agrupados por instrumento y su estado de selección.

**Escenarios de aceptación**:

1. **Dado** que abro la previsualización, **cuando** se renderiza el componente, **entonces** veo la descripción de la actuación, la población y la fecha.
2. **Dado** que la lista contiene usuarios, **cuando** se renderiza el modal, **entonces** los usuarios aparecen agrupados por instrumento.
3. **Dado** que un usuario está seleccionado o disponible en la lista, **cuando** se muestra su fila, **entonces** se refleja su estado visual correspondiente.

---

### Historia de usuario 2 - Consultar disponibilidad y detalles operativos de los músicos (Prioridad: P2)

Como usuario, quiero ver qué músicos están disponibles, si tienen coche o furgoneta y si forman parte de la lista para revisar la logística de la actuación.

**Por qué esta prioridad**: la utilidad operativa del módulo depende de la información de disponibilidad y medios de transporte.

**Prueba independiente**: abrir una lista y verificar que los campos de disponibilidad, selección y coche se muestran correctamente por usuario.

**Escenarios de aceptación**:

1. **Dado** que un usuario está marcado como no disponible, **cuando** se renderiza la lista, **entonces** no aparece como seleccionable.
2. **Dado** que un usuario tiene coche o furgoneta marcados en la relación pivote, **cuando** se muestra su fila, **entonces** se refleja esa información.
3. **Dado** que la actuación tiene datos de músicos o coches, **cuando** se abre la previsualización, **entonces** se muestran en el encabezado del modal.

### Casos límite

- ¿Qué ocurre si la actuación no existe?
- ¿Qué ocurre si la actuación no tiene lista asociada?
- ¿Qué ocurre si no hay usuarios activos o con instrumento?
- ¿Qué ocurre si el usuario autenticado no está en la lista o no tiene pivote disponible?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir abrir una previsualización modal de la lista asociada a una actuación.
- **FR-002**: El sistema debe mostrar la descripción, población y fecha de la actuación.
- **FR-003**: El sistema debe agrupar los usuarios por instrumento dentro del modal.
- **FR-004**: El sistema debe reflejar si cada usuario está seleccionado en la lista.
- **FR-005**: El sistema debe reflejar si cada usuario está disponible o no disponible.
- **FR-006**: El sistema debe reflejar si un usuario tiene coche o furgoneta en la relación pivote.
- **FR-007**: El sistema debe permitir abrir y cerrar el modal de previsualización.
- **FR-008**: El sistema debe mantener compatibilidad con la vista Blade existente y con los componentes reutilizados del proyecto.

### Superficie Laravel / Livewire

- **Livewire**: `app/Livewire/PreviewListas.php` contiene la lógica principal.
- **Vistas**: `resources/views/livewire/preview-listas.blade.php` presenta el modal y el detalle.
- **Modelos**: `Actuacion`, `Listas`, `ListasUser` y `User` sustentan la información mostrada.
- **Autenticación**: el componente depende de `Auth::user()` para el estado visual del usuario actual.

### Entidades clave

- **Actuación**: evento principal al que pertenece la lista.
- **Lista**: conjunto de usuarios asociados a la actuación.
- **ListasUser**: relación pivote con disponibilidad y transporte.
- **Usuario**: músico o participante mostrado en la previsualización.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario puede abrir la previsualización de una actuación y ver el encabezado del evento.
- **SC-002**: Un usuario puede inspeccionar la lista agrupada por instrumento.
- **SC-003**: Un usuario puede identificar disponibilidad, selección y transporte por fila.
- **SC-004**: El modal puede abrirse y cerrarse sin salir de la pantalla principal.
- **SC-005**: La implementación sigue funcionando con el estado Livewire y Blade existente.

## Suposiciones

- El módulo funciona como una previsualización operativa, no como un CRUD independiente.
- No se detectó una ruta explícita que monte este componente; puede ser consumido desde otra vista.
- La cobertura de pruebas del módulo parece inexistente, así que esta migración documenta comportamiento observado, no validado por tests dedicados.