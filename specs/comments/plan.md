# Plan de Implementación: Comments

**Branch**: `[comments]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/Comments/`, `app/Models/Comment.php`, `routes/web.php` y `resources/views/livewire/comments/`.

## Resumen

El módulo de Comments vive dentro del monolito Laravel y se implementa principalmente con Livewire. Cubre el listado con moderación, la creación de comentarios asociados a actuaciones y la edición de comentarios existentes con preservación del contexto operativo.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: Laravel Jetstream, Sanctum, Livewire, Eloquent, Validación de formularios, relación con actuaciones y usuarios

**Almacenamiento**: Base de datos Laravel existente con modelos `Comment`, `Actuacion` y `User`

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, sin cobertura dedicada detectada para Comments

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail, con interfaz administrativa y navegación existente

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener consultas con eager loading y filtros por usuario/comentario sin cargar datos innecesarios

**Restricciones**: Respetar autorización de roles, policies existentes, estructura Laravel 10-style conservada en el repo y comportamiento Livewire actual

**Alcance**: Módulo funcional de alcance medio, con listado, creación, edición y moderación lógica

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución vigente encaja con el módulo: monolito Laravel, UI en Blade/Livewire, pruebas PHPUnit y rutas con autorización existente.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/comments/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
├── Livewire/Comments/
├── Livewire/Dashboard/Comments/Forms/
├── Models/Comment.php
└── Models/Actuacion.php

resources/
└── views/livewire/comments/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se implementa dentro del monolito existente, con lógica de negocio y UI distribuidas entre Livewire, formularios, modelo y vistas Blade.

## Notas de implementación

- Priorizar las rutas y vistas ya existentes para no romper el comportamiento actual.
- Mantener la lógica de moderación como alternancia de flags, tal como hace el módulo.
- Reutilizar el modelo `Comment` y sus relaciones antes de introducir nuevas abstracciones.
- Si se ajusta alguna consulta, cuidar el eager loading y los filtros por texto y usuario para evitar N+1 y resultados inconsistentes.
- Documentar explícitamente el flujo JSON de creación, la moderación y la edición porque son ramas operativas del flujo principal.

## Complejidad

No se justifica una desviación de la constitución: el módulo ya sigue el patrón del repo, pero sí conviene reconocer que la cobertura de pruebas es limitada o inexistente.