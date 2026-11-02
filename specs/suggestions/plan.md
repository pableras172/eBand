# Plan de Implementación: Suggestions

**Branch**: `[suggestions]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/Suggestions/`, `app/Models/Suggestion.php`, `app/Livewire/Dashboard/Suggestions/Forms/`, `routes/web.php` y `resources/views/livewire/suggestions/`.

## Resumen

El módulo de Suggestions vive dentro del monolito Laravel y se implementa principalmente con Livewire. Cubre el listado filtrado por usuario, la creación de sugerencias con anonimato opcional, la edición y la moderación administrativa mediante observaciones.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: Laravel Jetstream, Sanctum, Livewire, Eloquent, validación de formularios, policies de sugerencias

**Almacenamiento**: Base de datos Laravel existente con el modelo `Suggestion` y su relación con `User`

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, sin cobertura dedicada detectada para Suggestions

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail, con interfaz administrativa y navegación existente

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener consultas con paginación, búsqueda y filtros por usuario sin cargar datos innecesarios

**Restricciones**: Respetar autorización de roles, policies existentes, estructura Laravel 10-style conservada en el repo y comportamiento Livewire actual

**Alcance**: Módulo funcional de alcance pequeño-medio, con listado, creación, edición y moderación administrativa

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución vigente encaja con el módulo: monolito Laravel, UI en Blade/Livewire, pruebas PHPUnit y rutas con autorización existente.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/suggestions/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
├── Livewire/Suggestions/
├── Livewire/Dashboard/Suggestions/Forms/
├── Models/Suggestion.php
└── Models/User.php

resources/
└── views/livewire/suggestions/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se implementa dentro del monolito existente, con lógica de negocio y UI distribuidas entre Livewire, formularios, modelo y vistas Blade.

## Notas de implementación

- Priorizar las rutas y vistas ya existentes para no romper el comportamiento actual.
- Mantener la lógica de visibilidad por usuario y la opción anónima como parte del flujo principal.
- Reutilizar el modelo `Suggestion` y sus formularios antes de introducir nuevas abstracciones.
- Si se ajusta alguna consulta, cuidar el filtro por usuario, búsqueda y paginación para evitar resultados inconsistentes.
- Documentar explícitamente la moderación administrativa y el evento `saved` porque son ramas operativas del flujo principal.

## Complejidad

No se justifica una desviación de la constitución: el módulo ya sigue el patrón del repo, pero sí conviene reconocer que la cobertura de pruebas es limitada o inexistente.