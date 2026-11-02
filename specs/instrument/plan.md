# Plan de Implementación: Instrumentos

**Branch**: `[instrument]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/Instrument/InstrumentClass.php`, `app/Models/Instrument.php`, `routes/web.php` y `resources/views/instrument/`.

## Resumen

El módulo de instrumentos proporciona el catálogo base de instrumentos de la banda. Incluye listado, alta, edición, eliminación, subida de iconos y reordenado manual mediante un endpoint específico.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: Eloquent, Storage, Validación de solicitudes, permisos de admin, Blade

**Almacenamiento**: Base de datos Laravel existente y archivos en `storage/imagenes/instruments`

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, sin cobertura dedicada detectada para Instrumentos

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener listado ordenado y reordenado sin sobrecargar la interfaz

**Restricciones**: Respetar la zona administrativa, el almacenamiento de iconos y las vistas Blade existentes

**Alcance**: Módulo administrativo de alcance medio

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución vigente encaja con este módulo: monolito Laravel, UI Blade, validación Laravel y permisos de administración.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/instrument/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
├── Livewire/Instrument/InstrumentClass.php
└── Models/Instrument.php

resources/
└── views/instrument/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se documenta tal como existe, sin separar todavía lógica de controlador y clase Livewire híbrida.

## Notas de implementación

- Mantener el orden por `orden` como criterio principal del listado.
- Documentar el endpoint `instrument.updateOrder` como parte del flujo administrativo.
- Preservar la validación de imágenes y el guardado en `storage/imagenes/instruments`.
- Registrar que la edición actualiza icono solo si se envía un nuevo archivo.
- Documentar la relación `hasMany` con usuarios porque otros módulos dependen de ella.

## Complejidad

La complejidad es media por la mezcla de CRUD, subida de archivos y reordenado. Aun así, el dominio está bien acotado y el comportamiento real es estable dentro del área administrativa.