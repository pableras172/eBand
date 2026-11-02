# Especificación de la Feature: Calendario de actuaciones

**Feature Branch**: `[calendario]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/AppointmentsCalendar.php` y `resources/views/livewire/calendario/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Ver un calendario interactivo de actuaciones (Prioridad: P1)

Como usuario de la aplicación, quiero ver un calendario interactivo para consultar eventos y actuar sobre días concretos sin abandonar la vista principal.

**Por qué esta prioridad**: el valor del módulo depende de mostrar una vista de calendario navegable y usable.

**Prueba independiente**: abrir la vista de calendario y verificar que se cargan eventos de ejemplo y que el día seleccionado puede disparar una vista de alta de evento.

**Escenarios de aceptación**:

1. **Dado** que abro el calendario, **cuando** se renderiza el componente, **entonces** se muestran eventos con fecha, título y descripción.
2. **Dado** que hago clic sobre un día, **cuando** el componente responde, **entonces** se abre la vista de creación de evento para ese día.
3. **Dado** que hago clic sobre un evento, **cuando** el componente recibe la interacción, **entonces** se ejecuta el manejador del evento aunque hoy no tenga lógica visible.

---

### Historia de usuario 2 - Preparar alta manual de eventos desde el calendario (Prioridad: P2)

Como usuario, quiero poder introducir un evento nuevo con título y fechas para completar manualmente el calendario.

**Por qué esta prioridad**: la interfaz ya expone un formulario, aunque el guardado real no está implementado.

**Prueba independiente**: abrir la vista de alta, completar el formulario y comprobar que el botón de envío llama a la acción Livewire esperada.

**Escenarios de aceptación**:

1. **Dado** que abro la vista de nuevo evento, **cuando** se carga el formulario, **entonces** aparecen los campos de título, inicio y fin.
2. **Dado** que envío datos válidos, **cuando** se ejecuta la acción de guardado, **entonces** el formulario se limpia y se emite una actualización del calendario.
3. **Dado** que ocurre un error durante el alta, **cuando** el componente lo captura, **entonces** se registra un mensaje de error para el usuario.

### Casos límite

- ¿Qué ocurre si el componente no está montado desde ninguna ruta explícita?
- ¿Qué ocurre si se abren vistas sin datos reales porque los eventos siguen hardcodeados?
- ¿Qué ocurre si se intenta guardar un evento sin persistencia real en base de datos?
- ¿Qué ocurre si el navegador no soporta el comportamiento esperado del calendario interactivo?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe mostrar un calendario interactivo con eventos visibles.
- **FR-002**: El sistema debe responder al clic sobre un día mostrando la vista de alta de evento.
- **FR-003**: El sistema debe permitir preparar el formulario de alta de evento con título, inicio y fin.
- **FR-004**: El sistema debe limpiar el formulario tras una acción de alta satisfactoria.
- **FR-005**: El sistema debe emitir una actualización de interfaz tras agregar un evento.
- **FR-006**: El sistema debe manejar errores de alta con un mensaje visible para el usuario.
- **FR-007**: El sistema debe mantener compatibilidad con las vistas Blade existentes del calendario.

### Superficie Laravel / Livewire

- **Livewire**: `app/Livewire/AppointmentsCalendar.php` contiene el componente principal.
- **Vistas**: `resources/views/livewire/calendario/showcalendar.blade.php` y `resources/views/livewire/calendario/new-event.blade.php` forman la interfaz visible.
- **Base técnica**: el componente extiende `Omnia\LivewireCalendar\LivewireCalendar`.

### Entidades clave

- **Evento de calendario**: entrada visual mostrada en el calendario.
- **Nuevo evento**: formulario para preparar una alta manual.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario puede abrir la pantalla de calendario y ver eventos de ejemplo.
- **SC-002**: Un clic sobre un día abre la vista de alta de evento.
- **SC-003**: El formulario de alta muestra los campos esperados y puede limpiarse tras enviar.
- **SC-004**: Un error durante el alta se comunica al usuario mediante un mensaje de sesión.
- **SC-005**: La implementación sigue siendo compatible con Livewire y con las vistas existentes.

## Suposiciones

- El componente funciona como base visual o prototipo dentro del monolito.
- No se detectó persistencia real de eventos en base de datos.
- No se detectó una ruta explícita que monte este componente; puede ser consumido desde otra vista o integrarse más adelante.
- La cobertura de pruebas del módulo parece inexistente, así que esta migración documenta comportamiento observado, no validado por tests dedicados.