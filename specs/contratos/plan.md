# Plan de Implementación: Contratos

**Branch**: `[contratos]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/Contratos/`, `app/Models/Contratos.php`, `routes/web.php` y `resources/views/livewire/contratos/`.

## Resumen

El módulo de Contratos vive dentro del monolito Laravel y se implementa principalmente con Livewire. Cubre el listado filtrado por año, la creación y edición de contratos, la eliminación, la duplicación y la consulta de actuaciones asociadas.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: Laravel Jetstream, Sanctum, Livewire, Eloquent, controlador de duplicado, geolocalización en formulario

**Almacenamiento**: Base de datos Laravel existente con el modelo `Contratos` y su relación con `Actuacion`

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, sin cobertura dedicada detectada para Contratos

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail, con interfaz administrativa y navegación existente

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener consultas con paginación y filtros por año sin cargar datos innecesarios

**Restricciones**: Respetar autorización de roles, policies existentes, estructura Laravel 10-style conservada en el repo y comportamiento Livewire actual

**Alcance**: Módulo funcional de alcance medio, con listado, CRUD, duplicado y actuaciones asociadas

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución vigente encaja con el módulo: monolito Laravel, UI en Blade/Livewire, pruebas PHPUnit y rutas con autorización existente.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/contratos/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
├── Livewire/Contratos/ListadoContratos.php
├── Models/Contratos.php
└── Http/Controllers/ContratosController.php

resources/
└── views/livewire/contratos/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se implementa dentro del monolito existente, con lógica de negocio y UI distribuidas entre Livewire, modelo, controlador de duplicado y vistas Blade.

## Notas de implementación

- Priorizar las rutas y vistas ya existentes para no romper el comportamiento actual.
- Mantener el listado por año y búsqueda como punto de entrada principal del módulo.
- Reutilizar el modelo `Contratos` y sus relaciones antes de introducir nuevas abstracciones.
- Si se ajusta alguna consulta, cuidar el filtrado por año y la paginación para evitar resultados inconsistentes.
- Documentar explícitamente el duplicado y la gestión de actuaciones asociadas porque son ramas operativas del flujo principal.

## Complejidad

No se justifica una desviación de la constitución: el módulo ya sigue el patrón del repo, pero sí conviene reconocer que la cobertura de pruebas es limitada o inexistente.