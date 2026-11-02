# Plan de Implementación: Actuaciones

**Branch**: `[actuaciones]` | **Fecha**: 2026-07-17 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Http/Controllers/ActuacionController.php`, `app/Livewire/Actuaciones/` y `resources/views/actuaciones/`.

## Resumen

El módulo de Actuaciones es una parte central del monolito Laravel. Gestiona la consulta pública de actuaciones visibles, la administración de actuaciones con borradores, y varias operaciones operativas como notificaciones, listados por tipo, mapas y resúmenes. La implementación combina controlador clásico, vistas Blade y componentes Livewire.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire 4 / Tailwind CSS 3 / Vite

**Dependencias principales**: Laravel Jetstream, Sanctum, Livewire, DomPDF, Excel, OneSignal, Carbon, Eloquent

**Almacenamiento**: Base de datos Laravel existente con modelos Eloquent y relaciones entre actuaciones, contratos, tipos y listas

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail, con interfaz pública y área administrativa

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener consultas eficientes con eager loading y filtros por fecha sin cargar datos innecesarios

**Restricciones**: Respetar autenticación, permisos de admin, middleware existente y la estructura Laravel 10-style ya conservada en el repo

**Alcance**: Módulo funcional de alcance medio-alto, con múltiples rutas, vistas y flujos operativos

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución vigente encaja con el módulo: monolito Laravel, UI en Blade/Livewire, pruebas PHPUnit y rutas con autorización existente.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/actuaciones/
├── plan.md
├── research.md
├── data-model.md
├── quickstart.md
├── contracts/
└── tasks.md
```

### Código fuente relevante

```text
app/
├── Http/Controllers/ActuacionController.php
├── Livewire/Actuaciones/
├── Models/Actuacion.php
├── Models/Contratos.php
├── Models/Tipoactuacion.php
├── Models/Listas.php
├── Models/ListasUser.php
└── Services/

database/
├── migrations/
├── factories/
└── seeders/

resources/
├── views/actuaciones/
├── views/livewire/contratos/
├── views/pdf/
└── views/public/

routes/
├── web.php
└── api.php

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se implementa dentro del monolito existente, sin separar backend y frontend en proyectos distintos.

## Notas de implementación

- Priorizar las rutas y vistas ya existentes para no romper el comportamiento actual.
- Mantener la lógica de orquestación en el controlador y dejar la UI en Blade/Livewire.
- Reutilizar los modelos y relaciones existentes antes de introducir nuevas abstracciones.
- Si se ajusta alguna consulta, cuidar el eager loading para evitar N+1.

## Complejidad

No se justifica una desviación de la constitución: el módulo ya sigue el patrón del repo.
