# Plan de Implementación: Actividades Internas

**Branch**: `feature/actividades-internas` | **Fecha**: 2026-11-02 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación de la feature "Actividades Internas" documentada en [spec.md](spec.md).

---

## Resumen

El módulo de **Actividades Internas** permite a la banda organizar eventos internos (comidas, cenas, excursiones, etc.) con gestión completa de opciones de menú o tickets a diferentes precios, inscripción reactiva para los músicos y sus acompañantes (con control de alergias/observaciones cuando aplique), y un panel administrativo para recuento de platos/asistentes, registro manual de pagos y exportación a Excel.

---

## Contexto técnico

* **Lenguaje/versión**: PHP 8.3 / Laravel 12 / Livewire 3 / Tailwind CSS 3 / Vite
* **Dependencias principales**: Livewire 3, Alpine.js (integrado), Laravel Excel (`maatwebsite/excel` o exportador nativo CSV/Excel), Eloquent
* **Almacenamiento**: Base de datos relacional MySQL/MariaDB con migraciones y modelos Eloquent
* **Pruebas**: PHPUnit 10 (`tests/Feature` y `tests/Unit`)
* **Reglas de arquitectura**: 
  - Estructura heredada de Laravel 10 (`app/Http/Kernel.php`, `app/Providers/RouteServiceProvider.php`).
  - Strict typing en PHP 8 (`declare(strict_types=1);`, tipos en parámetros y retornos).
  - Componentes Livewire 3 en namespace `App\Livewire\Actividades` con un único elemento raíz en Blade.
  - Validación mediante `FormRequest` o reglas estrictas en componentes Livewire.

---

## Estructura del proyecto

### Documentación de esta feature

```text
specs/actividades-internas/
├── spec.md
├── plan.md
└── tasks.md
```

### Código fuente a implementar

```text
app/
├── Http/Controllers/
│   └── ActividadExportController.php
├── Livewire/
│   └── Actividades/
│       ├── ActividadesIndex.php
│       ├── ActividadDetalle.php
│       ├── ActividadInscripcionForm.php
│       └── Admin/
│           ├── ActividadAdminIndex.php
│           ├── ActividadAdminForm.php
│           └── ActividadAdminDetail.php
├── Models/
│   ├── Actividad.php
│   ├── ActividadOpcion.php
│   ├── ActividadInscripcion.php
│   └── ActividadInscripcionItem.php
└── Exports/
    └── ActividadInscritosExport.php

database/
└── migrations/
    ├── 2026_11_02_000001_create_actividades_table.php
    ├── 2026_11_02_000002_create_actividad_opciones_table.php
    ├── 2026_11_02_000003_create_actividad_inscripciones_table.php
    └── 2026_11_02_000004_create_actividad_inscripcion_items_table.php

resources/views/
├── livewire/
│   └── actividades/
│       ├── actividades-index.blade.php
│       ├── actividad-detalle.blade.php
│       ├── actividad-inscripcion-form.blade.php
│       └── admin/
│           ├── actividad-admin-index.blade.php
│           ├── actividad-admin-form.blade.php
│           └── actividad-admin-detail.blade.php
└── exports/
    └── actividad-inscritos-excel.blade.php

routes/
└── web.php
```

---

## Fases de Implementación

1. **Fase 1: Base de Datos y Modelos**:
   - Crear migraciones con claves foráneas, restricciones únicas e índices.
   - Crear modelos con `casts()`, relaciones tipadas y scopes útiles (`abiertas()`, etc.).
2. **Fase 2: Gestión Administrativa (CRUD Actividad y Opciones)**:
   - Crear formulario Livewire para dar de alta actividades y configurar dinámicamente opciones con precios.
   - Listado administrativo de actividades con cambio de estado (`borrador`, `abierta`, `cerrada`).
3. **Fase 3: Vista de Músicos e Inscripción Reactiva**:
   - Listado público/músico de actividades abiertas con iconos y detalles.
   - Formulario de inscripción Livewire con selección de cantidades por opción, cálculo reactivo de total, campo condicional de alergias si es comida/cena, y envío de inscripción única.
   - Pantalla de confirmación/resumen de inscripción realizada.
4. **Fase 4: Panel de Control de Asistencia y Cobros (Admin)**:
   - Vista detallada de inscripciones con recuentos agregados por opción (para restaurante/proveedor).
   - Marcado de pagos con modal/dropdown de método (`bizum`, `efectivo`, etc.).
   - Capacidad de editar/cancelar inscripciones por parte del administrador.
5. **Fase 5: Exportación a Excel y Pruebas**:
   - Exportador de listado de asistentes, opciones y alergias.
   - Pruebas automatizadas PHPUnit cubriendo flujos de inscripción, validaciones y permisos.
