# Tareas: Configuration

**Entrada**: Documentos de diseño en `specs/configurations/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y toca comportamiento visible y operativo.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de implementación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar los puntos de entrada reales del módulo antes de documentar cada flujo.

- [x] T001 Confirmar el alcance del módulo en `app/Livewire/Configuration/`, `app/Livewire/Dashboard/Configurations/Forms/`, `app/Models/Configuration.php` y `resources/views/livewire/configurations/`
- [x] T002 [P] Identificar las rutas afectadas en `routes/web.php` para listado, creación y edición de configuraciones
- [x] T003 [P] Verificar la relación del modelo `Configuration` con `ConfigHelper`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el listado de configuraciones usa paginación, búsqueda y ordenación en `ConfigurationIndex`
- [x] T005 [P] Revisar que la creación valida `param` y `value` en `CreateForm` y `ConfigurationCreate`
- [x] T006 [P] Revisar que la edición conserva el contexto de la configuración y la unicidad del parámetro en `UpdateForm` y `ConfigurationEdit`
- [x] T007 Revisar que el listado ofrece eliminación y que el modelo refresca configuración al borrar
- [x] T008 Revisar que la autorización protege las operaciones de listado, creación y edición
- [x] T009 Confirmar que el módulo se apoya en la estructura monolítica existente sin dependencias externas nuevas

**Punto de control**: La base está lista; el módulo ya existe y puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Consultar, buscar y eliminar configuraciones existentes (Prioridad: P1)

**Objetivo**: Documentar el listado operativo de configuraciones con búsqueda y borrado.

**Prueba independiente**: Abrir el listado de configuraciones y comprobar que se pueden filtrar, ordenar y eliminar registros autorizados.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar `ConfigurationIndex::getRowsQueryProperty()` y su filtrado por `param`
- [x] T011 [P] [US1] Verificar `ConfigurationIndex::confirmDeletion()` y `delete()` sobre una configuración existente

### Implementación para la historia 1

- [x] T012 [P] [US1] Mantener la acción `mount()` en `app/Livewire/Configuration/ConfigurationIndex.php` como punto de entrada del listado
- [x] T013 [P] [US1] Mantener la vista `resources/views/livewire/configurations/index.blade.php` como salida principal de listados
- [x] T014 [US1] Preservar la paginación, búsqueda y ordenación del listado
- [x] T015 [US1] Mantener la eliminación autorizada de configuraciones desde el listado
- [x] T016 [US1] Mantener el refresco de configuración después de borrar una entrada
- [x] T017 [US1] Confirmar que la historia funciona independientemente del flujo de creación o edición

**Punto de control**: La historia 1 queda documentada y lista como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Crear configuraciones con parámetro y valor válidos (Prioridad: P1)

**Objetivo**: Documentar la creación de configuraciones con unicidad de parámetro.

**Prueba independiente**: Ejecutar la creación con un parámetro y valor válidos y comprobar que la configuración se crea y refresca el helper.

### Pruebas para la historia 2

- [x] T018 [P] [US2] Verificar la inicialización del componente en `ConfigurationCreate::mount()`
- [x] T019 [P] [US2] Verificar la validación de `CreateForm` y la unicidad de `param`

### Implementación para la historia 2

- [x] T020 [P] [US2] Documentar el flujo de creación en `app/Livewire/Configuration/ConfigurationCreate.php`
- [x] T021 [P] [US2] Documentar la persistencia del parámetro y el valor en `Configuration`
- [x] T022 [US2] Mantener la redirección a la edición de la configuración tras guardar desde Livewire
- [x] T023 [US2] Mantener la recarga de configuración tras crear una entrada
- [x] T024 [US2] Confirmar que la historia queda acotada al flujo de alta y no rompe el listado

**Punto de control**: La historia 2 queda completa y alimenta el flujo operativo de configuraciones.

---

## Fase 5: Historia de usuario 3 - Editar configuraciones existentes y conservar la coherencia del sistema (Prioridad: P2)

**Objetivo**: Documentar la edición de la configuración y la preservación de la unicidad.

**Prueba independiente**: Abrir una configuración existente, modificarla y comprobar que el formulario conserva el contexto y refresca el helper.

### Pruebas para la historia 3

- [x] T025 [P] [US3] Verificar `ConfigurationEdit::mount()` y la carga del formulario con contexto
- [x] T026 [P] [US3] Verificar `ConfigurationEdit::save()` y la persistencia de cambios

### Implementación para la historia 3

- [x] T027 [P] [US3] Documentar la ruta de edición `app/Livewire/Configuration/ConfigurationEdit.php`
- [x] T028 [P] [US3] Documentar la preservación de parámetro y valor en `UpdateForm`
- [x] T029 [US3] Mantener la validación de unicidad del parámetro al editar
- [x] T030 [US3] Mantener el refresco de configuración tras guardar cambios
- [x] T031 [US3] Confirmar que la edición no rompe la moderación del listado ni la recarga de configuración

**Punto de control**: La historia 3 queda documentada como la capa de mantenimiento y coherencia.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T032 [P] Documentar que no se añadieron nuevas dependencias ni servicios externos para esta migración
- [x] T033 [P] Documentar que la cobertura de pruebas es inexistente o no se detectó en el módulo Configuration
- [x] T034 Revisar que no se introducen conflictos con autenticación, permisos ni middleware existente
- [x] T035 Revisar consistencia entre componentes Livewire, formularios, modelo y vistas Blade del módulo
- [x] T036 Registrar que existen oportunidades de ampliar pruebas para unicidad, refresco y borrado
- [x] T037 Marcar la feature como migrada con gap de cobertura, no como feature nueva

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende de las demás
- **Historia 2**: proporciona la creación de configuraciones que luego se editan y borran
- **Historia 3**: depende del contexto de configuración ya existente, pero sigue siendo independiente en la práctica

### Dentro de cada historia

- Las pruebas van antes que la implementación documental correspondiente
- Los modelos y relaciones se documentan antes que las operaciones que dependen de ellos
- La autorización y validación se mantienen antes de las acciones de persistencia o refresco

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010 y T011 se pueden revisar en paralelo
- T018 y T019 se pueden revisar en paralelo
- T025 y T026 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Consolidar Historia 2 porque es donde se crean configuraciones nuevas.
3. Validar Historia 1 como consulta y borrado del listado.
4. Validar Historia 3 como capa de mantenimiento y coherencia.

### Entrega incremental

1. Base documental del módulo.
2. Listado y eliminación.
3. Creación con parámetro único.
4. Edición y refresco de configuración.

### Estrategia de equipo

1. Una persona revisa el listado y las rutas.
2. Otra persona revisa creación y validación de unicidad.
3. Otra persona revisa edición, helper y documentación de pruebas.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La cobertura detectada es limitada o ausente y conviene ampliarla si se quiere cerrar más comportamiento operativo.