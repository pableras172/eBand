# Plan de Implementación: Payments

**Branch**: `[payments]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/Payment/`, `app/Models/Payment.php`, `app/Models/Paymentresume.php`, `routes/web.php` y `resources/views/livewire/payments/`.

## Resumen

El módulo de Payments vive dentro del monolito Laravel y se implementa principalmente con Livewire. Cubre el listado de pagos, la creación de pagos y resúmenes a partir de actuaciones, la edición del detalle del pago, la confirmación o rechazo por parte del usuario y el envío del detalle por correo.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: Laravel Jetstream, Sanctum, Livewire, Mail, Eloquent, Carbon, DB transaction, Notificaciones por email

**Almacenamiento**: Base de datos Laravel existente con modelos `Payment`, `Paymentresume`, `ListasUser`, `Listas`, `Actuacion` y `User`

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, sin cobertura dedicada detectada para Payments

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail, con interfaz administrativa y navegación existente

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener consultas con eager loading y filtros por usuario/fechas sin cargar datos innecesarios

**Restricciones**: Respetar autorización de roles, policies existentes, estructura Laravel 10-style conservada en el repo y comportamiento Livewire actual

**Alcance**: Módulo funcional de alcance medio, con lista, creación, edición, confirmación y detalle por listas

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución vigente encaja con el módulo: monolito Laravel, UI en Blade/Livewire, pruebas PHPUnit y rutas con autorización existente.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/payments/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
├── Livewire/Payment/
├── Models/Payment.php
├── Models/Paymentresume.php
├── Models/ListasUser.php
├── Models/Listas.php
├── Models/Actuacion.php
└── Mail/PaymentDetail.php

resources/
├── views/livewire/payments/
└── views/livewire/payments/paymentresumes/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

**Decisión de estructura**: el módulo se implementa dentro del monolito existente, con lógica de negocio y UI distribuidas entre Livewire, modelos y vistas Blade.

## Notas de implementación

- Priorizar las rutas y vistas ya existentes para no romper el comportamiento actual.
- Mantener la lógica de cálculo de pagos dentro de los componentes y modelos ya usados por el módulo.
- Reutilizar los modelos y relaciones existentes antes de introducir nuevas abstracciones.
- Si se ajusta alguna consulta, cuidar el eager loading y los filtros por fecha para evitar N+1 y resultados inconsistentes.
- Documentar explícitamente el comportamiento de confirmación, rechazo y email porque son ramas operativas del flujo principal.

## Complejidad

No se justifica una desviación de la constitución: el módulo ya sigue el patrón del repo, pero sí conviene reconocer que la cobertura de pruebas es limitada o inexistente.