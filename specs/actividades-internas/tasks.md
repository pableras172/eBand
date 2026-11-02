# Tareas: Actividades Internas

**Entrada**: Documentos de diseño en `specs/actividades-internas/` (`spec.md` y `plan.md`)

**Prerequisitos**: Docker/Sail activo para migraciones y tests.

---

## Formato: `[ID] [P?] [Story] Descripción`
- **[P]**: Ejecutable en paralelo
- **[Story]**: Historia de usuario asociada (US1..US5) o Fase base

---

## Fase 1: Base de Datos y Persistencia

**Propósito**: Crear el esquema de base de datos y modelos Eloquent con relaciones y tipado estricto.

- [x] T001 Crear migración `create_actividades_table` con campos `titulo`, `tipo`, `descripcion`, `lugar`, `fecha`, `fecha_limite_inscripcion`, `estado`, `instrucciones_pago`
- [x] T002 Crear migración `create_actividad_opciones_table` con campos `actividad_id`, `titulo`, `descripcion`, `precio`
- [x] T003 Crear migración `create_actividad_inscripciones_table` con campos `actividad_id`, `user_id`, `fecha_inscripcion`, `total`, `observaciones_alergias`, `pagado`, `metodo_pago`, `fecha_pago` y clave única `[actividad_id, user_id]`
- [x] T004 Crear migración `create_actividad_inscripcion_items_table` con campos `actividad_inscripcion_id`, `actividad_opcion_id`, `cantidad`, `precio_unitario`, `subtotal`
- [x] T005 [P] Crear modelo `App\Models\Actividad.php` con método `casts()`, scopes y relaciones `opciones()` e `inscripciones()`
- [x] T006 [P] Crear modelo `App\Models\ActividadOpcion.php` con método `casts()` y relación `actividad()`
- [x] T007 [P] Crear modelo `App\Models\ActividadInscripcion.php` con método `casts()` y relaciones `actividad()`, `user()` e `items()`
- [x] T008 [P] Crear modelo `App\Models\ActividadInscripcionItem.php` con método `casts()` y relaciones `inscripcion()` y `opcion()`

---

## Fase 2: Historia 3 - Gestión Administrativa de Actividades y Opciones (US3)

**Propósito**: Permitir al administrador configurar actividades y sus opciones de menú/precios.

- [x] T009 [US3] Crear componente Livewire `App\Livewire\Actividades\Admin\ActividadAdminIndex` para listar actividades con filtros y estado
- [x] T010 [US3] Crear componente Livewire `App\Livewire\Actividades\Admin\ActividadAdminForm` para creación y edición de actividades
- [x] T011 [US3] Implementar en el formulario la gestión dinámica de opciones (añadir/quitar filas de opciones con título, descripción y precio)
- [x] T012 [US3] Registrar rutas de administración en `routes/web.php` protegidas por autenticación y roles administrativos
- [x] T013 [US3] Diseñar vistas Blade de administración con Tailwind CSS respetando estilos del panel existente

---

## Fase 3: Historias 1 y 2 - Visualización e Inscripción para Músicos (US1, US2)

**Propósito**: Permitir a los músicos consultar eventos, seleccionar opciones y enviar su inscripción única.

- [x] T014 [US1] Crear componente Livewire `App\Livewire\Actividades\ActividadesIndex` para mostrar a los músicos las actividades disponibles con iconos según `tipo`
- [x] T015 [US2] Crear componente Livewire `App\Livewire\Actividades\ActividadInscripcionForm` para la selección de cantidades por opción
- [x] T016 [US2] Implementar cálculo reactivo instantáneo del importe total en el componente de inscripción
- [x] T017 [US2] Mostrar condicionalmente el campo de observaciones y alergias cuando `tipo` sea `comida` o `cena`
- [x] T018 [US2] Validar y persistir la inscripción creando el registro en `actividad_inscripciones` y sus líneas en `actividad_inscripcion_items`
- [x] T019 [US2] Implementar vista de confirmación y resumen posterior al envío, con estado de pago e instrucciones de pago (bloqueando modificaciones directas del músico)
- [x] T020 [US1] Registrar rutas públicas/músico en `routes/web.php` e integrar el enlace en la barra de navegación principal

---

## Fase 4: Historia 4 - Control de Asistencia, Recuento de Platos y Pagos (US4)

**Propósito**: Dotar a los administradores de métricas de recuento de opciones y gestión de pagos.

- [x] T021 [US4] Crear componente Livewire `App\Livewire\Actividades\Admin\ActividadAdminDetail` con dashboard de la actividad
- [x] T022 [US4] Implementar tarjeta de métricas con el recuento acumulado de cada opción solicitada (ej. número total de cada menú)
- [x] T023 [US4] Implementar balance de recaudación (Total previsto, Total recaudado, Total pendiente)
- [x] T024 [US4] Crear tabla de inscritos con desglose de opciones, alergias y estado de pago
- [x] T025 [US4] Implementar acción/modal para marcar inscripción como "Pagada" registrando opcionalmente el método (`bizum`, `efectivo`, `transferencia`)
- [x] T026 [US4] Permitir al administrador editar o dar de baja una inscripción a petición de un músico
- [x] T031 [US4] Permitir al administrador inscribir directamente a miembros de la banda o personas externas/sin cuenta seleccionando platos/opciones y cobro inicial
- [x] T032 [US4] Permitir al administrador editar inscripciones existentes directamente desde la tabla nominal
- [x] T033 [US2] Permitir a los músicos indicar explícitamente "No voy" (no asistencia), cambiar de opinión antes del plazo límite y filtrar no asistentes en administración

---

## Fase 5: Historia 5 - Exportación a Excel y Validación Final (US5)

**Propósito**: Descarga de datos para proveedores y pruebas del sistema.

- [x] T027 [US5] Implementar clase de exportación `App\Exports\ActividadInscritosExport` o controlador `ActividadExportController` para descarga en Excel/CSV
- [x] T028 [US5] Añadir botón de descarga en el panel administrativo de la actividad
- [x] T029 Crear pruebas unitarias y de integración en `tests/Feature/ActividadInscripcionTest.php` cubriendo inscripción única, cálculo de totales y permisos
- [x] T030 Ejecutar formateador Laravel Pint (`vendor/bin/sail bin pint --dirty`) y verificar cumplimiento de convenciones
