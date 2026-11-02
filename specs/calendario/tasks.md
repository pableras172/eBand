# Tareas: Calendario de actuaciones

**Entrada**: Documentos de diseño en `specs/calendario/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y el comportamiento visible es importante.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de documentación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar la superficie real del módulo antes de documentar el flujo.

- [x] T001 Confirmar el componente principal en `app/Livewire/AppointmentsCalendar.php`
- [x] T002 [P] Confirmar las vistas reales en `resources/views/livewire/calendario/showcalendar.blade.php` y `resources/views/livewire/calendario/new-event.blade.php`
- [x] T003 [P] Verificar que no existe una ruta explícita detectada para montar el componente

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el componente extiende `LivewireCalendar`
- [x] T005 [P] Revisar que `events()` devuelve eventos visibles de ejemplo
- [x] T006 [P] Revisar que `onDayClick()` devuelve la vista de alta de evento
- [x] T007 Revisar que `addEvent()` limpia campos y emite actualización
- [x] T008 Revisar que el manejo de errores muestra mensaje de sesión
- [x] T009 Confirmar que no se detectó persistencia real en base de datos

**Punto de control**: La base está lista; el módulo puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Ver un calendario interactivo de actuaciones (Prioridad: P1)

**Objetivo**: Documentar la pantalla principal del calendario y su interacción básica.

**Prueba independiente**: Abrir la vista del calendario y comprobar que muestra eventos y responde al clic sobre un día.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar la estructura de `resources/views/livewire/calendario/showcalendar.blade.php`
- [x] T011 [P] [US1] Verificar que `onDayClick()` devuelve `livewire.calendario.new-event`
- [x] T012 [P] [US1] Verificar que `onEventClick()` y `onEventDropped()` existen como puntos de interacción

### Implementación para la historia 1

- [x] T013 [P] [US1] Documentar el comportamiento visual del calendario en `app/Livewire/AppointmentsCalendar.php`
- [x] T014 [P] [US1] Documentar la vista principal `resources/views/livewire/calendario/showcalendar.blade.php`
- [x] T015 [US1] Preservar el uso de eventos de ejemplo para la vista
- [x] T016 [US1] Mantener la interacción al seleccionar un día
- [x] T017 [US1] Registrar que esta historia es independiente del guardado real

**Punto de control**: La historia 1 queda documentada como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Preparar alta manual de eventos desde el calendario (Prioridad: P2)

**Objetivo**: Documentar el formulario de alta de evento y su flujo de envío.

**Prueba independiente**: Abrir el formulario, completar los campos y comprobar la acción de envío.

### Pruebas para la historia 2

- [x] T018 [P] [US2] Verificar la estructura de `resources/views/livewire/calendario/new-event.blade.php`
- [x] T019 [P] [US2] Verificar que `addEvent()` limpia los campos del formulario
- [x] T020 [P] [US2] Verificar que `addEvent()` emite `eventAdded` tras un alta satisfactoria

### Implementación para la historia 2

- [x] T021 [P] [US2] Documentar el formulario de alta de evento en `resources/views/livewire/calendario/new-event.blade.php`
- [x] T022 [P] [US2] Documentar la lógica de alta de evento en `app/Livewire/AppointmentsCalendar.php`
- [x] T023 [US2] Mantener la limpieza de campos tras enviar
- [x] T024 [US2] Mantener el mensaje de error si ocurre una excepción
- [x] T025 [US2] Confirmar que la historia es una preparación visual y no un CRUD persistente

**Punto de control**: La historia 2 queda documentada como capa complementaria del calendario.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T026 [P] Documentar que no se detectaron rutas explícitas para este componente
- [x] T027 [P] Documentar que no se detectaron pruebas dedicadas para el calendario
- [x] T028 Revisar consistencia entre componente, vistas y dependencias Livewire
- [x] T029 Registrar que el módulo no persiste eventos en el estado observado
- [x] T030 Marcar la feature como migrada con gap de integración y persistencia

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende de la persistencia
- **Historia 2**: depende de la vista y del manejador de guardado

### Dentro de cada historia

- La prueba va antes que la documentación de implementación correspondiente
- El componente principal se documenta antes que la vista secundaria
- La ausencia de persistencia se registra antes de cerrar la historia

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010, T011 y T012 se pueden revisar en paralelo
- T018, T019 y T020 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Documentar la pantalla principal del calendario.
3. Documentar el formulario de alta manual.
4. Cerrar con los gaps de integración y persistencia.

### Entrega incremental

1. Base documental del componente.
2. Vista principal del calendario.
3. Formulario de nuevo evento.
4. Registro de gaps y ausencia de pruebas.

### Estrategia de equipo

1. Una persona revisa componente y dependencias.
2. Otra persona revisa vistas y flujo visual.
3. Otra persona revisa gaps y documentación de pruebas.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La brecha principal es que el calendario parece prototipo visual sin persistencia real detectada.