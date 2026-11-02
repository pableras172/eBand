# Plan de Implementación: Mapa de ubicaciones

**Branch**: `[location-map]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/LocationMap.php` y `resources/views/livewire/location-map.blade.php`.

## Resumen

El módulo de LocationMap es una superficie Livewire pequeña y reutilizable que pinta un mapa Leaflet, añade marcadores y permite actualizar ubicaciones mediante eventos del navegador. Se usa como bloque visual incrustado en varias pantallas del sistema.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: Livewire, Leaflet, Nominatim/OpenStreetMap, Auth, Blade

**Almacenamiento**: No se detectó persistencia propia del mapa en el componente analizado

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, sin cobertura dedicada detectada para LocationMap

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener una inicialización ligera y actualizaciones de marcadores sin recarga completa

**Restricciones**: Respetar el montaje embebido en vistas existentes y la dependencia de Leaflet en el frontend

**Alcance**: Módulo pequeño de visualización reutilizable

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución del repo encaja con este módulo: monolito Laravel, UI Blade/Livewire y validación PHPUnit. La advertencia principal es que parte de la lógica vive en la vista Blade y depende de scripts externos.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/location-map/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
└── Livewire/LocationMap.php

resources/
└── views/livewire/location-map.blade.php

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se documenta como un bloque Livewire embebible, sin extraer todavía la inicialización JS fuera de la vista.

## Notas de implementación

- Mantener la altura configurable como parámetro de montaje.
- Documentar la API pública `window.MapComponent` y los eventos `location-map:add` y `location-map:set`.
- Registrar que el mapa geocodifica por nombre cuando no hay coordenadas.
- Mantener el fallback del icono basado en el instrumento del usuario autenticado.
- Documentar los montajes reales en actuaciones, contrato y bienvenida porque forman parte del uso del componente.

## Complejidad

La complejidad es baja a nivel de PHP, pero media en el frontend porque el comportamiento depende de Leaflet, eventos del navegador y servicios externos de geocodificación.