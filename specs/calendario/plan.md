# Plan de Implementación: Calendario de actuaciones

**Branch**: `[calendario]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/AppointmentsCalendar.php` y `resources/views/livewire/calendario/`.

## Resumen

El módulo de calendario es una superficie Livewire muy pequeña que presenta eventos de ejemplo y una vista de alta manual. El comportamiento observado está más cerca de un prototipo funcional que de un CRUD persistente.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: `omnia/livewire-calendar`, Livewire, Blade, Carbon

**Almacenamiento**: No se detectó persistencia propia del calendario en el componente analizado

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, sin cobertura dedicada detectada para el calendario

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener una vista ligera y rápida de calendario

**Restricciones**: Respetar la estructura existente del repo y la integración Livewire ya elegida

**Alcance**: Módulo pequeño, centrado en visualización y preparación de eventos

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución del repo encaja con este módulo: monolito Laravel, UI Blade/Livewire y validación PHPUnit. La única advertencia es la falta de persistencia y de pruebas dedicadas.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/calendario/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
└── Livewire/AppointmentsCalendar.php

resources/
└── views/livewire/calendario/

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se documenta como una superficie Livewire aislada, sin crear nuevas capas o servicios adicionales.

## Notas de implementación

- Mantener la dependencia de `LivewireCalendar` como base del comportamiento del calendario.
- Documentar los eventos de ejemplo como comportamiento observado, no como datos persistidos.
- No asumir una ruta pública específica si no está presente en el código analizado.
- Reconocer que `addEvent()` hoy limpia campos y emite evento, pero no persiste en base de datos.
- Documentar la vista `new-event.blade.php` como la interfaz de alta de evento y `showcalendar.blade.php` como la vista principal del calendario.

## Complejidad

La complejidad es baja, pero el módulo tiene una brecha clara entre UI y persistencia. Eso conviene dejarlo explícito en la documentación migrada.