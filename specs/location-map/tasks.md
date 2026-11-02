# Tareas: Mapa de ubicaciones

**Entrada**: Documentos de diseño en `specs/location-map/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y depende de comportamiento de frontend visible.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de documentación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar la superficie real del módulo antes de documentar el flujo.

- [x] T001 Confirmar el componente principal en `app/Livewire/LocationMap.php`
- [x] T002 [P] Confirmar la vista principal en `resources/views/livewire/location-map.blade.php`
- [x] T003 [P] Confirmar los montajes reales en actuaciones, contrato y bienvenida

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el componente acepta altura configurable en `mount()`
- [x] T005 [P] Revisar que la vista inicializa Leaflet y el grupo de marcadores
- [x] T006 [P] Revisar que existe geocoding por nombre cuando faltan coordenadas
- [x] T007 Revisar que existe icono de marcador basado en el usuario autenticado
- [x] T008 Revisar que la API pública del navegador expone `MapComponent`
- [x] T009 Confirmar que no se detectó persistencia propia en base de datos

**Punto de control**: La base está lista; el módulo puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Visualizar un mapa interactivo de ubicaciones (Prioridad: P1)

**Objetivo**: Documentar la visualización principal del mapa reutilizable.

**Prueba independiente**: Abrir una vista que monte el componente y comprobar que el mapa se carga y centra correctamente.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar el contenedor principal y la altura en `resources/views/livewire/location-map.blade.php`
- [x] T011 [P] [US1] Verificar que el mapa usa `data-municipios` como entrada inicial
- [x] T012 [P] [US1] Verificar que existe un fallback de vista cuando no hay municipios

### Implementación para la historia 1

- [x] T013 [P] [US1] Documentar la inicialización del mapa en `resources/views/livewire/location-map.blade.php`
- [x] T014 [P] [US1] Documentar la altura configurable desde `app/Livewire/LocationMap.php`
- [x] T015 [US1] Mantener el fit de vista según marcadores o centro por defecto
- [x] T016 [US1] Mantener la carga de marcadores iniciales desde backend
- [x] T017 [US1] Confirmar que la historia es de visualización y no de edición persistente

**Punto de control**: La historia 1 queda documentada como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Añadir y sustituir municipios en el mapa dinámicamente (Prioridad: P2)

**Objetivo**: Documentar la API pública y los eventos del navegador para actualizar el mapa.

**Prueba independiente**: Emitir eventos de navegador y comprobar que el mapa añade o sustituye municipios.

### Pruebas para la historia 2

- [x] T018 [P] [US2] Verificar que `location-map:add` añade un marcador individual
- [x] T019 [P] [US2] Verificar que `location-map:set` reemplaza todos los marcadores
- [x] T020 [P] [US2] Verificar que el componente intenta geocodificar cuando faltan coordenadas

### Implementación para la historia 2

- [x] T021 [P] [US2] Documentar la API `window.MapComponent`
- [x] T022 [P] [US2] Documentar los listeners `location-map:add` y `location-map:set`
- [x] T023 [US2] Mantener el uso de Nominatim como geocoding externo
- [x] T024 [US2] Mantener el fallback del icono del marcador
- [x] T025 [US2] Confirmar que la historia complementa el uso en otras vistas

**Punto de control**: La historia 2 queda documentada como capa dinámica complementaria.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T026 [P] Documentar que no se detectaron pruebas dedicadas para LocationMap
- [x] T027 [P] Documentar que el componente depende de Leaflet y scripts externos
- [x] T028 Revisar consistencia entre componente, vista y montajes en otras pantallas
- [x] T029 Registrar que la lógica principal vive en el Blade y no en una clase de servicio
- [x] T030 Marcar la feature como migrada con gap de cobertura, no como feature nueva

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende de la API dinámica
- **Historia 2**: depende del mapa ya inicializado y de la API pública

### Dentro de cada historia

- La prueba va antes que la documentación de implementación correspondiente
- La inicialización del mapa se documenta antes que la API dinámica
- La dependencia de scripts externos se registra antes de cerrar la historia

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010, T011 y T012 se pueden revisar en paralelo
- T018, T019 y T020 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Documentar la visualización principal del mapa.
3. Documentar la API dinámica de actualización.
4. Cerrar con los gaps de cobertura y dependencia externa.

### Entrega incremental

1. Base documental del componente.
2. Mapa visible en pantallas consumidoras.
3. Eventos para añadir y sustituir municipios.
4. Registro de gaps y ausencia de pruebas.

### Estrategia de equipo

1. Una persona revisa componente y montajes.
2. Otra persona revisa vista y comportamiento Leaflet.
3. Otra persona revisa API pública y geocoding.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La brecha principal es la dependencia de JavaScript externo y servicios de geocodificación.