# Tareas: Actuaciones

**Entrada**: Documentos de diseño en `specs/actuaciones/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo ya tiene cobertura parcial y cambia comportamiento visible y operativo.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de implementación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar los puntos de entrada reales del módulo antes de tocar lógica.

- [x] T001 Confirmar el alcance del módulo en `app/Http/Controllers/ActuacionController.php`, `app/Livewire/Actuaciones/` y `resources/views/actuaciones/`
- [x] T002 [P] Identificar las rutas afectadas en `routes/web.php` para actuación, notificación, mapas y listados operativos
- [x] T003 [P] Verificar los modelos compartidos en `app/Models/Actuacion.php`, `app/Models/Contratos.php`, `app/Models/Tipoactuacion.php` y `app/Models/Listas.php`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que la relación entre actuaciones y contratos está presente y se usa en consultas con eager loading
- [x] T005 [P] Revisar que la validación de creación/edición cubre los campos obligatorios y `is_draft`
- [x] T006 [P] Revisar que las vistas públicas y administrativas existen en `resources/views/actuaciones/` y `resources/views/livewire/contratos/`
- [x] T007 Revisar que la autenticación y autorización admin protegen las operaciones de modificación y notificación
- [x] T008 Revisar que existen pruebas del módulo, aunque sean parciales, en `tests/Feature/ActuacionDraftFeatureTest.php`
- [x] T009 Confirmar que el módulo se apoya en la estructura monolítica existente sin dependencias externas nuevas

**Punto de control**: La base está lista; el módulo ya existe y puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Consulta pública de actuaciones (Prioridad: P1)

**Objetivo**: Documentar y mantener la consulta pública de actuaciones visibles y agrupadas.

**Prueba independiente**: Abrir la vista pública y comprobar que muestra actuaciones visibles, filtradas y agrupadas por fecha.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar la vista pública `resources/views/actuaciones/view-listas.blade.php` y sus agrupaciones por mes/fecha
- [x] T011 [P] [US1] Verificar que las relaciones `contrato` y `tipoactuacion` se cargan en `ActuacionController@index`

### Implementación para la historia 1

- [x] T012 [P] [US1] Mantener la acción `index()` en `app/Http/Controllers/ActuacionController.php` como punto de entrada de consulta pública
- [x] T013 [P] [US1] Mantener la vista `resources/views/actuaciones/view-listas.blade.php` como salida principal de listados públicos
- [x] T014 [US1] Preservar la agrupación por mes y el orden ascendente por `fechaActuacion`
- [x] T015 [US1] Mantener la exposición de tipos de actuación y poblaciones relacionadas
- [x] T016 [US1] Confirmar que la consulta pública no rompe el acceso ni la navegación existentes
- [x] T017 [US1] Validar que la historia funciona independientemente del flujo administrativo

**Punto de control**: La historia 1 queda documentada y lista como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Gestión administrativa y borradores (Prioridad: P1)

**Objetivo**: Documentar la creación, edición y guardado de actuaciones, incluyendo borradores.

**Prueba independiente**: Crear y editar una actuación autenticado como admin, comprobando validación y persistencia de `is_draft`.

### Pruebas para la historia 2

- [x] T018 [P] [US2] Cubrir `tests/Feature/ActuacionDraftFeatureTest.php` para creación, actualización y cast de `is_draft`
- [x] T019 [P] [US2] Verificar la validación de campos obligatorios en `ActuacionController@store`

### Implementación para la historia 2

- [x] T020 [P] [US2] Documentar el flujo de creación en `app/Http/Controllers/ActuacionController.php@store`
- [x] T021 [P] [US2] Documentar la edición y persistencia de actuaciones existentes
- [x] T022 [US2] Preservar el valor por defecto de `visible`, `oficial` e `is_draft`
- [x] T023 [US2] Mantener la asociación con contratos y tipos de actuación
- [x] T024 [US2] Mantener la interacción con la vista `resources/views/livewire/contratos/actuacions.blade.php`
- [x] T025 [US2] Confirmar que el comportamiento de borrador queda cubierto por pruebas

**Punto de control**: La historia 2 queda completa y es la principal cobertura de pruebas existente.

---

## Fase 5: Historia de usuario 3 - Operaciones, notificaciones y mapas (Prioridad: P2)

**Objetivo**: Documentar la capa operativa del módulo: notificaciones, ubicaciones, calendarios y listados auxiliares.

**Prueba independiente**: Ejecutar las rutas operativas sobre una actuación existente y verificar respuesta o error comprensible.

### Pruebas para la historia 3

- [x] T026 [P] [US3] Verificar `notificarActuacion()` y `notificarActuacionLista()` en `ActuacionController`
- [x] T027 [P] [US3] Verificar `ubicacionesContratos()` y las rutas de detalle/listado asociadas

### Implementación para la historia 3

- [x] T028 [P] [US3] Documentar la ruta de notificación de actuaciones y su dependencia de permisos admin
- [x] T029 [P] [US3] Documentar la ruta JSON de ubicaciones para mapas operativos
- [x] T030 [US3] Documentar la integración con OneSignal y mensajes localizados
- [x] T031 [US3] Mantener la generación de ICS/calendario dentro del flujo de actuación
- [x] T032 [US3] Mantener el uso de listas, listados por tipo, fecha y población en las vistas operativas
- [x] T033 [US3] Confirmar que los fallos de notificación o datos incompletos devuelven mensajes comprensibles

**Punto de control**: La historia 3 queda documentada como la capa operativa complementaria.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T034 [P] Documentar que no se añadieron nuevas dependencias ni servicios externos para esta migración
- [x] T035 [P] Documentar que la cobertura de pruebas es parcial y se concentra en `is_draft`
- [x] T036 Revisar que no se introducen conflictos con autenticación, permisos ni middleware existente
- [x] T037 Revisar consistencia entre controlador, vistas Livewire y vistas Blade del módulo
- [x] T038 Registrar que existen oportunidades de ampliar pruebas para notificaciones, mapas y listados públicos
- [x] T039 Marcar la feature como migrada con gap de cobertura parcial, no como feature nueva

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende de las demás
- **Historia 2**: puede validarse de forma independiente y es la base de la cobertura de pruebas existente
- **Historia 3**: reutiliza datos y permisos de las historias anteriores, pero sigue siendo independiente en la práctica

### Dentro de cada historia

- Las pruebas van antes que la implementación documental correspondiente
- Los modelos y relaciones se documentan antes que las operaciones que dependen de ellos
- La autorización y validación se mantienen antes de las acciones de persistencia o notificación

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010 y T011 se pueden revisar en paralelo
- T018 y T019 se pueden revisar en paralelo
- T026 y T027 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Consolidar Historia 2 porque es donde existe cobertura de pruebas concreta.
3. Validar Historia 1 como consulta pública.
4. Validar Historia 3 como capa operativa.

### Entrega incremental

1. Base documental del módulo.
2. Consulta pública.
3. Gestión administrativa y borradores.
4. Operaciones, notificaciones y mapas.

### Estrategia de equipo

1. Una persona revisa el controlador y rutas.
2. Otra persona revisa vistas y Livewire.
3. Otra persona amplía pruebas para notificaciones y mapas.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La cobertura detectada es parcial y conviene ampliarla si se quiere cerrar más comportamiento operativo.