# Plan de Implementación: Announcements

**Branch**: `[announcements]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/Announcement/`, `app/Models/Announcement.php`, `routes/web.php` y `resources/views/livewire/announcement/`.

## Resumen

El módulo de Announcements vive dentro del monolito Laravel y se implementa principalmente con Livewire. Cubre el listado, la creación, la edición, la notificación a usuarios objetivo y la visualización de un popup de anuncios para usuarios autenticados.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: Laravel Jetstream, Sanctum, Livewire, Notificaciones de Laravel, Eloquent, Carbon, Instrumentos y estados de anuncio

**Almacenamiento**: Base de datos Laravel existente con modelos `Announcement`, `AnnouncementStatus`, `Instrument` y `User`

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, sin cobertura dedicada detectada para Announcements

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail, con interfaz administrativa y consumo por usuarios autenticados

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener consultas con eager loading, métricas derivadas y filtrado por búsqueda sin cargar datos innecesarios

**Restricciones**: Respetar autorización de roles, policies existentes, estructura Laravel 10-style conservada en el repo y comportamiento Livewire actual

**Alcance**: Módulo funcional de alcance medio, con lista, formularios, notificación y popup público/privado

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución vigente encaja con el módulo: monolito Laravel, UI en Blade/Livewire, pruebas PHPUnit y rutas con autorización existente.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/announcements/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
├── Livewire/Announcement/
├── Models/Announcement.php
├── Models/AnnouncementStatus.php
├── Models/Instrument.php
└── Notifications/AnnouncementPublishedNotification.php

resources/
└── views/livewire/announcement/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se implementa dentro del monolito existente, con lógica de negocio y UI distribuidas entre Livewire, modelos, notificaciones y vistas Blade.

## Notas de implementación

- Priorizar las rutas y vistas ya existentes para no romper el comportamiento actual.
- Mantener la lógica de notificación dentro del componente de listado, como ya hace el módulo.
- Reutilizar el modelo `Announcement` y sus scopes antes de introducir nuevas abstracciones.
- Si se ajusta alguna consulta, cuidar el eager loading y los filtros por ventana activa para evitar N+1 y resultados inconsistentes.
- Documentar explícitamente el popup, la notificación y el tracking de lectura/cierre porque son ramas operativas del flujo principal.

## Complejidad

No se justifica una desviación de la constitución: el módulo ya sigue el patrón del repo, pero sí conviene reconocer que la cobertura de pruebas es limitada o inexistente.