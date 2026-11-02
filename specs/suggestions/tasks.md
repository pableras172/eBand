# Tareas: Suggestions

**Entrada**: Documentos de diseño en `specs/suggestions/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y toca comportamiento visible y operativo.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de implementación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar los puntos de entrada reales del módulo antes de documentar cada flujo.

- [x] T001 Confirmar el alcance del módulo en `app/Livewire/Suggestions/`, `app/Livewire/Dashboard/Suggestions/Forms/`, `app/Models/Suggestion.php` y `resources/views/livewire/suggestions/`
- [x] T002 [P] Identificar las rutas afectadas en `routes/web.php` para listado, creación y edición de sugerencias
- [x] T003 [P] Verificar la relación de `Suggestion` con `User`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el listado de sugerencias usa paginación, búsqueda y ordenación en `SuggestionIndex`
- [x] T005 [P] Revisar que la creación valida fecha, título, texto, observaciones y anonimato en `CreateForm` y `SuggestionCreate`
- [x] T006 [P] Revisar que la edición conserva el contexto de la sugerencia en `UpdateForm` y `SuggestionEdit`
- [x] T007 Revisar que el listado limita la visibilidad por usuario cuando no hay rol admin
- [x] T008 Revisar que la autorización protege las operaciones de listado, creación, edición y borrado
- [x] T009 Confirmar que el módulo se apoya en la estructura monolítica existente sin dependencias externas nuevas

**Punto de control**: La base está lista; el módulo ya existe y puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Consultar mis sugerencias y eliminarlas (Prioridad: P1)

**Objetivo**: Documentar el listado operativo de sugerencias con búsqueda y borrado.

**Prueba independiente**: Abrir el listado de sugerencias y comprobar que se pueden filtrar y eliminar sugerencias propias.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar `SuggestionIndex::render()` y el filtrado por usuario no administrador
- [x] T011 [P] [US1] Verificar `SuggestionIndex::confirmDeletion()` y `delete()` sobre una sugerencia existente

### Implementación para la historia 1

- [x] T012 [P] [US1] Mantener la acción `render()` en `app/Livewire/Suggestions/SuggestionIndex.php` como punto de entrada del listado
- [x] T013 [P] [US1] Mantener la vista `resources/views/livewire/suggestions/index.blade.php` como salida principal de listados
- [x] T014 [US1] Preservar la paginación, búsqueda y ordenación del listado
- [x] T015 [US1] Mantener la restricción de visibilidad por usuario para no administradores
- [x] T016 [US1] Confirmar que la historia funciona independientemente del flujo de creación o edición

**Punto de control**: La historia 1 queda documentada y lista como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Crear sugerencias con o sin anonimato (Prioridad: P1)

**Objetivo**: Documentar la creación de sugerencias con fecha, título, texto y anonimato opcional.

**Prueba independiente**: Crear una sugerencia válida y comprobar que se guarda con el usuario y la fecha correctos.

### Pruebas para la historia 2

- [x] T017 [P] [US2] Verificar la inicialización del componente en `SuggestionCreate::mount()`
- [x] T018 [P] [US2] Verificar la validación de `CreateForm` y la persistencia desde `SuggestionCreate::save()`

### Implementación para la historia 2

- [x] T019 [P] [US2] Documentar el flujo de creación en `app/Livewire/Suggestions/SuggestionCreate.php`
- [x] T020 [P] [US2] Documentar la persistencia del autor, la fecha y el anonimato en `Suggestion`
- [x] T021 [US2] Mantener la redirección al listado tras guardar desde Livewire
- [x] T022 [US2] Confirmar que la historia queda acotada al flujo de alta y no rompe el listado

**Punto de control**: La historia 2 queda completa y alimenta el flujo operativo de sugerencias.

---

## Fase 5: Historia de usuario 3 - Editar sugerencias y moderarlas como administrador (Prioridad: P2)

**Objetivo**: Documentar la edición de sugerencias y la moderación con observaciones.

**Prueba independiente**: Abrir una sugerencia existente, editarla y comprobar que un administrador puede completar observaciones.

### Pruebas para la historia 3

- [x] T023 [P] [US3] Verificar `SuggestionEdit::mount()` y la carga del formulario con contexto
- [x] T024 [P] [US3] Verificar `SuggestionEdit::save()` y la persistencia de cambios

### Implementación para la historia 3

- [x] T025 [P] [US3] Documentar la ruta de edición `app/Livewire/Suggestions/SuggestionEdit.php`
- [x] T026 [P] [US3] Documentar la preservación de anonimato, usuario y fecha en `UpdateForm`
- [x] T027 [US3] Mantener la moderación administrativa mediante observaciones
- [x] T028 [US3] Mantener el evento `saved` tras guardar cambios
- [x] T029 [US3] Confirmar que la edición no rompe la moderación ni el listado

**Punto de control**: La historia 3 queda documentada como la capa de mantenimiento y moderación.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T030 [P] Documentar que no se añadieron nuevas dependencias ni servicios externos para esta migración
- [x] T031 [P] Documentar que la cobertura de pruebas es inexistente o no se detectó en el módulo Suggestions
- [x] T032 Revisar que no se introducen conflictos con autenticación, permisos ni middleware existente
- [x] T033 Revisar consistencia entre componentes Livewire, formularios, modelo y vistas Blade del módulo
- [x] T034 Registrar que existen oportunidades de ampliar pruebas para filtro por usuario, anonimato y moderación
- [x] T035 Marcar la feature como migrada con gap de cobertura, no como feature nueva

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende de las demás
- **Historia 2**: proporciona las sugerencias que luego se editan y moderan
- **Historia 3**: depende del contexto de sugerencia ya existente, pero sigue siendo independiente en la práctica

### Dentro de cada historia

- Las pruebas van antes que la implementación documental correspondiente
- Los modelos y relaciones se documentan antes que las operaciones que dependen de ellos
- La autorización y validación se mantienen antes de las acciones de persistencia o moderación

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010 y T011 se pueden revisar en paralelo
- T017 y T018 se pueden revisar en paralelo
- T023 y T024 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Consolidar Historia 2 porque es donde se crean sugerencias nuevas.
3. Validar Historia 1 como consulta del listado.
4. Validar Historia 3 como capa de mantenimiento y moderación.

### Entrega incremental

1. Base documental del módulo.
2. Listado por usuario y búsqueda.
3. Creación con anonimato opcional.
4. Edición y observaciones administrativas.

### Estrategia de equipo

1. Una persona revisa el listado y las rutas.
2. Otra persona revisa creación y anonimato.
3. Otra persona revisa edición, observaciones y documentación de pruebas.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La cobertura detectada es limitada o ausente y conviene ampliarla si se quiere cerrar más comportamiento operativo.