# Plan de Implementación: Inventory

**Branch**: `[inventory]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/Inventory/`, `app/Models/InventoryItem.php`, `app/Models/InventoryCategory.php`, `app/Models/InventoryMovement.php`, `app/Http/Controllers/InventoryExportController.php`, `routes/web.php` y `resources/views/livewire/inventory/`.

## Resumen

El módulo de Inventory vive dentro del monolito Laravel y se implementa principalmente con Livewire. Cubre el listado filtrable del inventario, la creación y edición de ítems con responsables, la consulta del detalle, las estadísticas por categoría y la exportación a Excel y PDF.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: Laravel Jetstream, Sanctum, Livewire, Eloquent, DomPDF, Excel, policies de inventario

**Almacenamiento**: Base de datos Laravel existente con modelos `InventoryItem`, `InventoryCategory`, `InventoryMovement` y `User`

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, sin cobertura dedicada detectada para Inventory

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail, con interfaz administrativa y navegación existente

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener consultas con eager loading, filtros por rol y agregaciones por categoría sin cargar datos innecesarios

**Restricciones**: Respetar autorización de roles, policies existentes, estructura Laravel 10-style conservada en el repo y comportamiento Livewire actual

**Alcance**: Módulo funcional de alcance medio-alto, con lista, creación, edición, detalle, estadísticas y exportación

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución vigente encaja con el módulo: monolito Laravel, UI en Blade/Livewire, pruebas PHPUnit y rutas con autorización existente.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/inventory/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
├── Livewire/Inventory/
├── Models/InventoryItem.php
├── Models/InventoryCategory.php
├── Models/InventoryMovement.php
└── Http/Controllers/InventoryExportController.php

resources/
└── views/livewire/inventory/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se implementa dentro del monolito existente, con lógica de negocio y UI distribuidas entre Livewire, modelos, controlador de exportación y vistas Blade.

## Notas de implementación

- Priorizar las rutas y vistas ya existentes para no romper el comportamiento actual.
- Mantener la lógica de movimientos de inventario dentro de creación y edición, tal como hace el módulo.
- Reutilizar el modelo `InventoryItem` y sus relaciones antes de introducir nuevas abstracciones.
- Si se ajusta alguna consulta, cuidar el eager loading y los filtros por año, categoría y estado para evitar N+1 y resultados inconsistentes.
- Documentar explícitamente las exportaciones, las estadísticas y el cálculo de valor residual porque son ramas operativas del flujo principal.

## Complejidad

No se justifica una desviación de la constitución: el módulo ya sigue el patrón del repo, pero sí conviene reconocer que la cobertura de pruebas es limitada o inexistente.