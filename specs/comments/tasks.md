# Tareas: Comments

**Entrada**: Documentos de diseño en `specs/comments/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y toca comportamiento visible y operativo.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de implementación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar los puntos de entrada reales del módulo antes de documentar cada flujo.

- [x] T001 Confirmar el alcance del módulo en `app/Livewire/Comments/`, `app/Livewire/Dashboard/Comments/Forms/`, `app/Models/Comment.php` y `resources/views/livewire/comments/`
- [x] T002 [P] Identificar las rutas afectadas en `routes/web.php` para listado, creación y edición de comentarios
- [x] T003 [P] Verificar la relación de `Comment` con `Actuacion` y `User`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el listado de comentarios usa paginación, búsqueda y ordenación en `CommentIndex`
- [x] T005 [P] Revisar que la creación valida los campos obligatorios en `CreateForm` y `CommentCreate`
- [x] T006 [P] Revisar que la edición conserva el contexto de usuario, actuación y flags en `UpdateForm` y `CommentEdit`
- [x] T007 Revisar que el listado ofrece acciones de eliminación lógica y denuncia
- [x] T008 Revisar que la autorización protege las operaciones de listado, creación y edición
- [x] T009 Confirmar que el módulo se apoya en la estructura monolítica existente sin dependencias externas nuevas

**Punto de control**: La base está lista; el módulo ya existe y puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Consultar y moderar comentarios existentes (Prioridad: P1)

**Objetivo**: Documentar el listado operativo de comentarios con búsqueda y moderación lógica.

**Prueba independiente**: Abrir el listado de comentarios y comprobar que se pueden filtrar, marcar como eliminados y denunciar registros autorizados.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar `CommentIndex::getRowsQueryProperty()` y su filtrado por comentario o nombre de usuario
- [x] T011 [P] [US1] Verificar `CommentIndex::confirmDeletion()` y `delete()` sobre un comentario existente
- [x] T012 [P] [US1] Verificar `CommentIndex::confirmDenuncia()` y `denuncia()` sobre un comentario existente

### Implementación para la historia 1

- [x] T013 [P] [US1] Mantener la acción `mount()` en `app/Livewire/Comments/CommentIndex.php` como punto de entrada del listado
- [x] T014 [P] [US1] Mantener la vista `resources/views/livewire/comments/index.blade.php` como salida principal de listados
- [x] T015 [US1] Preservar la paginación, búsqueda y ordenación del listado
- [x] T016 [US1] Mantener la alternancia de `eliminado` como moderación lógica
- [x] T017 [US1] Mantener la alternancia de `inadecuado` como denuncia de contenido
- [x] T018 [US1] Confirmar que la historia funciona independientemente del flujo de creación o edición

**Punto de control**: La historia 1 queda documentada y lista como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Crear comentarios asociados a actuaciones (Prioridad: P1)

**Objetivo**: Documentar la alta de comentarios vinculados a una actuación y al usuario autenticado.

**Prueba independiente**: Ejecutar la creación válida y comprobar que el comentario queda asociado al usuario y a la actuación indicada.

### Pruebas para la historia 2

- [x] T019 [P] [US2] Verificar la inicialización del componente en `CommentCreate::mount()`
- [x] T020 [P] [US2] Verificar la validación de `CreateForm` y la persistencia desde `CommentCreate::save()`
- [x] T021 [P] [US2] Verificar la ruta JSON manual `CommentCreate::store()` con datos válidos

### Implementación para la historia 2

- [x] T022 [P] [US2] Documentar el flujo de creación en `app/Livewire/Comments/CommentCreate.php`
- [x] T023 [P] [US2] Documentar la persistencia del comentario con usuario autenticado y actuación
- [x] T024 [US2] Mantener la redirección a la edición del comentario tras guardar desde Livewire
- [x] T025 [US2] Mantener la respuesta JSON de éxito para la ruta manual
- [x] T026 [US2] Confirmar que la historia queda acotada al flujo de alta y no rompe el listado

**Punto de control**: La historia 2 queda completa y alimenta el flujo operativo de comentarios.

---

## Fase 5: Historia de usuario 3 - Editar comentarios y revisar contexto operativo (Prioridad: P2)

**Objetivo**: Documentar la edición del comentario y la conservación del contexto operativo.

**Prueba independiente**: Abrir un comentario existente, modificarlo y comprobar que el formulario conserva usuario, fecha, actuación y estados de moderación.

### Pruebas para la historia 3

- [x] T027 [P] [US3] Verificar `CommentEdit::mount()` y la carga del formulario con contexto
- [x] T028 [P] [US3] Verificar `CommentEdit::save()` y la persistencia de cambios

### Implementación para la historia 3

- [x] T029 [P] [US3] Documentar la ruta de edición `app/Livewire/Comments/CommentEdit.php`
- [x] T030 [P] [US3] Documentar la preservación de usuario, actuación y flags operativos
- [x] T031 [US3] Mantener la edición con redirección al listado tras guardar
- [x] T032 [US3] Mantener la relación con la vista `resources/views/livewire/comments/edit.blade.php`
- [x] T033 [US3] Confirmar que la edición no rompe la moderación ni el listado

**Punto de control**: La historia 3 queda documentada como la capa de mantenimiento y contexto.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T034 [P] Documentar que no se añadieron nuevas dependencias ni servicios externos para esta migración
- [x] T035 [P] Documentar que la cobertura de pruebas es inexistente o no se detectó en el módulo Comments
- [x] T036 Revisar que no se introducen conflictos con autenticación, permisos ni middleware existente
- [x] T037 Revisar consistencia entre componentes Livewire, formularios, modelo y vistas Blade del módulo
- [x] T038 Registrar que existen oportunidades de ampliar pruebas para moderación lógica, JSON y edición
- [x] T039 Marcar la feature como migrada con gap de cobertura, no como feature nueva

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende de las demás
- **Historia 2**: proporciona la creación de comentarios que luego se editan y moderan
- **Historia 3**: depende del contexto de comentario ya existente, pero sigue siendo independiente en la práctica

### Dentro de cada historia

- Las pruebas van antes que la implementación documental correspondiente
- Los modelos y relaciones se documentan antes que las operaciones que dependen de ellos
- La autorización y validación se mantienen antes de las acciones de persistencia o moderación

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010, T011 y T012 se pueden revisar en paralelo
- T019, T020 y T021 se pueden revisar en paralelo
- T027 y T028 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Consolidar Historia 2 porque es donde se crea el comentario.
3. Validar Historia 1 como consulta y moderación del listado.
4. Validar Historia 3 como capa de mantenimiento del comentario.

### Entrega incremental

1. Base documental del módulo.
2. Listado y moderación lógica.
3. Creación con asociación a actuación.
4. Edición y revisión de contexto.

### Estrategia de equipo

1. Una persona revisa el listado y las rutas.
2. Otra persona revisa creación y JSON.
3. Otra persona revisa edición y la documentación de pruebas.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La cobertura detectada es limitada o ausente y conviene ampliarla si se quiere cerrar más comportamiento operativo.