# Plan de Implementación: Previsualización de listas

**Branch**: `[preview-listas]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/PreviewListas.php` y `resources/views/livewire/preview-listas.blade.php`.

## Resumen

El módulo de PreviewListas es una superficie Livewire compacta que muestra una lista modal de usuarios asociados a una actuación. El comportamiento observado está centrado en visualización, agrupación por instrumento y estado operativo de cada músico.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: Livewire, Blade, Eloquent, Auth, relaciones de `Actuacion`, `Listas`, `ListasUser` y `User`

**Almacenamiento**: Base de datos Laravel existente con relaciones entre actuaciones, listas y usuarios

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, sin cobertura dedicada detectada para PreviewListas

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener la consulta y agrupación de usuarios suficientemente ligeras para la vista modal

**Restricciones**: Respetar la estructura del repo, la dependencia de Auth y los componentes Blade reutilizados

**Alcance**: Módulo pequeño de previsualización y consulta operativa

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución del repo encaja con este módulo: monolito Laravel, UI Blade/Livewire y validación PHPUnit. La advertencia principal es que el flujo parece montado desde otra vista y no desde una ruta explícita.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/preview-listas/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
└── Livewire/PreviewListas.php

resources/
└── views/livewire/preview-listas.blade.php

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se documenta como una superficie Livewire aislada, sin introducir nuevas capas de servicio.

## Notas de implementación

- Mantener la lógica de agrupación por instrumento como parte del comportamiento observado.
- Documentar la dependencia de `Auth::user()` para resaltar el tratamiento del estado del usuario actual.
- No asumir una ruta pública si no está presente en el código analizado.
- Registrar que el componente mezcla consulta, marcado de estado y presentación en el mismo `render()`.
- Documentar la vista modal y el botón de apertura como la interfaz visible principal.

## Complejidad

La complejidad es baja, pero hay acoplamiento entre cálculo de datos y presentación. Conviene dejar eso explícito en la documentación migrada.