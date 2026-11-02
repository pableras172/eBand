# Plan de Implementación: Perfil de usuario

**Branch**: `[profile-information]` | **Fecha**: 2026-07-18 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación migrada desde el código existente en `app/Livewire/UpdateProfileInformationForm.php`, `app/Providers/JetstreamServiceProvider.php`, `resources/views/profile/update-profile-information-form.blade.php` y `tests/Feature/ProfileInformationTest.php`.

## Resumen

El módulo de perfil de usuario amplía el formulario estándar de Jetstream para incluir foto, instrumento y datos operativos del músico. La actualización se hace desde un componente Livewire registrado por alias y consumido en la pantalla de perfil.

## Contexto técnico

**Lenguaje/versión**: PHP 8.3 / Laravel 13 / Livewire / Tailwind CSS 3 / Vite

**Dependencias principales**: Jetstream, Fortify, Livewire, Auth, Instrument

**Almacenamiento**: Base de datos Laravel existente y almacenamiento de fotos de perfil gestionado por Jetstream

**Pruebas**: PHPUnit en `tests/Feature` y `tests/Unit`, con cobertura básica detectada para actualización de perfil

**Plataforma objetivo**: Aplicación web Laravel servida mediante Sail

**Tipo de proyecto**: Monolito web

**Objetivos de rendimiento**: Mantener una carga ligera del formulario y una actualización inmediata de la navegación tras guardar

**Restricciones**: Respetar la integración con Jetstream/Fortify, los permisos por rol y la vista existente

**Alcance**: Módulo pequeño de cuenta y perfil extendido

## Revisión de constitución

**GATE**: Debe pasar antes del diseño detallado.

La constitución del repo encaja con este módulo: monolito Laravel, UI Blade/Livewire y pruebas PHPUnit. El único punto delicado es el desajuste entre el namespace usado en la prueba y el componente local actual.

## Estructura del proyecto

### Documentación de esta feature

```text
specs/profile-information/
├── plan.md
├── spec.md
└── tasks.md
```

### Código fuente relevante

```text
app/
├── Livewire/UpdateProfileInformationForm.php
└── Providers/JetstreamServiceProvider.php

resources/
└── views/profile/update-profile-information-form.blade.php

tests/
└── Feature/ProfileInformationTest.php
```

**Decisión de estructura**: el módulo se documenta como una extensión del perfil de Jetstream, sin introducir una capa adicional de servicio.

## Notas de implementación

- Mantener la carga de estado desde el usuario autenticado en `mount()`.
- Documentar el selector de instrumento como parte de la ficha de perfil extendida.
- Respetar la lógica condicional por rol Admin para los campos extra.
- Registrar que la vista ofrece subida, previsualización y borrado de foto cuando Jetstream lo permite.
- Mantener la actualización de navegación y la verificación de correo como parte del flujo de guardado.

## Complejidad

La complejidad es baja a nivel funcional, aunque existe acoplamiento con Jetstream y Fortify. La cobertura de pruebas es básica y conviene alinear el test con el namespace actual si se amplía este módulo.