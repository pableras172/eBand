# Tareas: Contratos

**Entrada**: Documentos de diseño en `specs/contratos/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y toca comportamiento visible y operativo.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de implementación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar los puntos de entrada reales del módulo antes de documentar cada flujo.

- [x] T001 Confirmar el alcance del módulo en `app/Livewire/Contratos/ListadoContratos.php`, `app/Models/Contratos.php` y `resources/views/livewire/contratos/`
- [x] T002 [P] Identificar las rutas afectadas en `routes/web.php` para listado, creación, edición, duplicado y actuaciones por contrato
- [x] T003 [P] Verificar la relación de `Contratos` con `Actuacion`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el listado de contratos usa paginación, búsqueda y filtro por año en `ListadoContratos`
- [x] T005 [P] Revisar que la creación valida población, fechas y datos de contacto en `ListadoContratos::store()`
- [x] T006 [P] Revisar que la edición conserva el contexto del contrato en `ListadoContratos::edit()` y `update()`
- [x] T007 Revisar que la eliminación autorizada existe en `ListadoContratos::destroy()`
- [x] T008 Revisar que la autorización protege las operaciones de listado, creación, edición y eliminación
- [x] T009 Confirmar que el módulo se apoya en la estructura monolítica existente sin dependencias externas nuevas

**Punto de control**: La base está lista; el módulo ya existe y puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Consultar contratos por año y buscar por contenido (Prioridad: P1)

**Objetivo**: Documentar el listado operativo de contratos con filtro temporal y búsqueda.

**Prueba independiente**: Abrir el listado de contratos, cambiar de año y comprobar que la búsqueda se conserva.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar `ListadoContratos::getContratosForYear()` y su filtrado por año
- [x] T011 [P] [US1] Verificar la búsqueda por población, descripción y contacto en `ListadoContratos::index()` y `contratosPorAnyo()`

### Implementación para la historia 1

- [x] T012 [P] [US1] Mantener la acción `index()` en `app/Livewire/Contratos/ListadoContratos.php` como punto de entrada del listado
- [x] T013 [P] [US1] Mantener la vista `resources/views/livewire/contratos/index.blade.php` como salida principal de listados
- [x] T014 [US1] Preservar la paginación, búsqueda y selector de año
- [x] T015 [US1] Mantener la navegación al detalle, edición y duplicado desde el listado
- [x] T016 [US1] Confirmar que la historia funciona independientemente del flujo de edición

**Punto de control**: La historia 1 queda documentada y lista como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Crear, editar y eliminar contratos (Prioridad: P1)

**Objetivo**: Documentar el CRUD de contratos con validación y mensajes de resultado.

**Prueba independiente**: Crear, editar y eliminar un contrato válido comprobando las validaciones y respuestas.

### Pruebas para la historia 2

- [x] T017 [P] [US2] Verificar la validación de `ListadoContratos::store()`
- [x] T018 [P] [US2] Verificar la validación de `ListadoContratos::update()`
- [x] T019 [P] [US2] Verificar `ListadoContratos::destroy()` y su manejo de error

### Implementación para la historia 2

- [x] T020 [P] [US2] Documentar el flujo de creación en `app/Livewire/Contratos/ListadoContratos.php`
- [x] T021 [P] [US2] Documentar el flujo de edición y actualización de contratos existentes
- [x] T022 [US2] Mantener la eliminación autorizada de contratos desde el formulario
- [x] T023 [US2] Mantener los mensajes de éxito, borrado y error asociados al CRUD
- [x] T024 [US2] Confirmar que la historia queda acotada al flujo administrativo y no rompe el listado

**Punto de control**: La historia 2 queda completa y es el núcleo operativo de Contratos.

---

## Fase 5: Historia de usuario 3 - Gestionar actuaciones asociadas y duplicar contratos (Prioridad: P2)

**Objetivo**: Documentar la consulta de actuaciones ligadas al contrato y su duplicado.

**Prueba independiente**: Abrir un contrato, revisar sus actuaciones y ejecutar la duplicación.

### Pruebas para la historia 3

- [x] T025 [P] [US3] Verificar la vista `resources/views/livewire/contratos/actuacions.blade.php` y las actuaciones asociadas
- [x] T026 [P] [US3] Verificar la ruta `contratos.duplicate` y su comportamiento esperado

### Implementación para la historia 3

- [x] T027 [P] [US3] Documentar la vista `resources/views/livewire/contratos/actuacions.blade.php`
- [x] T028 [P] [US3] Documentar la navegación a actuaciones, edición y duplicado desde el listado
- [x] T029 [US3] Mantener la relación entre contrato y actuaciones en la interfaz
- [x] T030 [US3] Mantener la operación de duplicado de contrato como flujo existente
- [x] T031 [US3] Confirmar que la historia no rompe el resto del flujo de Contratos

**Punto de control**: La historia 3 queda documentada como la capa operativa complementaria.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T032 [P] Documentar que no se añadieron nuevas dependencias ni servicios externos para esta migración
- [x] T033 [P] Documentar que la cobertura de pruebas es inexistente o no se detectó en el módulo Contratos
- [x] T034 Revisar que no se introducen conflictos con autenticación, permisos ni middleware existente
- [x] T035 Revisar consistencia entre componente Livewire, modelo y vistas Blade del módulo
- [x] T036 Registrar que existen oportunidades de ampliar pruebas para duplicado, año y validaciones del formulario
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
- **Historia 2**: proporciona los contratos que luego se consultan y duplican
- **Historia 3**: depende del contrato ya existente, pero sigue siendo independiente en la práctica

### Dentro de cada historia

- Las pruebas van antes que la implementación documental correspondiente
- El modelo y la navegación se documentan antes que las operaciones que dependen de ellos
- La autorización y validación se mantienen antes de las acciones de persistencia o duplicado

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010 y T011 se pueden revisar en paralelo
- T017 y T018 se pueden revisar en paralelo
- T025 y T026 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Consolidar Historia 2 porque es donde vive el CRUD principal.
3. Validar Historia 1 como consulta del listado.
4. Validar Historia 3 como capa operativa complementaria.

### Entrega incremental

1. Base documental del módulo.
2. Listado por año y búsqueda.
3. CRUD de contratos.
4. Actuaciones asociadas y duplicado.

### Estrategia de equipo

1. Una persona revisa el listado y las rutas.
2. Otra persona revisa creación, edición y eliminación.
3. Otra persona revisa actuaciones asociadas y duplicado.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La cobertura detectada es limitada o ausente y conviene ampliarla si se quiere cerrar más comportamiento operativo.