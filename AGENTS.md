# 🤖 Guía de Agentes de IA - eBand

Este documento define el contexto técnico, las directrices de arquitectura, las reglas de codificación, las herramientas MCP disponibles, los agentes de Spec-Kit y las habilidades (*skills*) de este repositorio para agentes de IA y asistentes de desarrollo.

---

## 📌 1. Contexto del Proyecto y Stack Tecnológico

El proyecto **eBand** es una aplicación desarrollada en **Laravel** con las siguientes versiones clave del ecosistema:

| Componente / Paquete | Versión | Rol / Descripción |
| :--- | :--- | :--- |
| **PHP** | 8.3.28 | Versión de runtime |
| **laravel/framework** | v12 | Framework principal (mantiene estructura tradicional de Laravel 10) |
| **laravel/sail** | v1 | Entorno de desarrollo local basado en Docker |
| **livewire/livewire** | v3 | Componentes reactivos del frontend |
| **tailwindcss** | v3 | Framework CSS utilitario |
| **phpunit/phpunit** | v10 | Suite de pruebas automatizadas |
| **laravel/pint** | v1 | Formateador de estilo de código PHP |
| **laravel/fortify** | v1 | Backend de autenticación |
| **laravel/sanctum** | v4 | Tokens API y autenticación SPA |
| **laravel/pulse** | v1 | Monitorización de rendimiento y salud de la app |
| **laravel/cashier** | v15 | Facturación y pagos |
| **laravel/prompts** | v0 | Consola interactiva |
| **laravel/mcp** | v0 | Servidor de protocolo MCP |

### ⚠️ Estructura heredada de Laravel 10
Aunque el proyecto utiliza Laravel 12, **no** se ha migrado a la nueva estructura simplificada de Laravel 11/12. Se debe respetar la convención existente:
- Middleware en `app/Http/Middleware/` y registro en `app/Http/Kernel.php`.
- Manejo de excepciones en `app/Exceptions/Handler.php`.
- Comandos de consola y programación de tareas en `app/Console/Kernel.php`.
- Proveedores de servicios en `app/Providers/` (como `RouteServiceProvider`).
- No existe `bootstrap/app.php` para configuración unificada; no intentes forzarla ni crearla sin petición expresa.

---

## 🐳 2. Reglas de Ejecución con Laravel Sail

El entorno local se ejecuta íntegramente dentro de los contenedores Docker de Sail. **Todos los comandos de PHP, Composer, Artisan y Node DEBEN ejecutarse a través de Sail.**

- **Artisan**: `vendor/bin/sail artisan <comando>`
- **Composer**: `vendor/bin/sail composer <comando>`
- **NPM / Vite**: `vendor/bin/sail npm run dev` o `vendor/bin/sail npm run build`
- **PHP**: `vendor/bin/sail php <script>`
- **Gestión de servicios**: `vendor/bin/sail up -d` y `vendor/bin/sail stop`

> [!WARNING]
> No ejecutes comandos directos como `php artisan` o `composer` en el host si pueden ejecutarse dentro del contenedor Sail.

---

## 🛠️ 3. Herramientas MCP (Laravel Boost)

Cuando estén disponibles las herramientas MCP de Laravel Boost:

1. **`search-docs` (Prioridad Alta)**:
   - Consulta siempre la documentación oficial específica de la versión antes de realizar cambios estructurales o utilizar APIs del framework.
   - Pasa múltiples términos simples por temática (ej: `['rate limiting', 'routing']`). No incluyas nombres de paquetes ya instalados.
2. **`list-artisan-commands`**: Úsala para verificar argumentos y opciones disponibles antes de lanzar comandos Artisan.
3. **`get-absolute-url`**: Genera URLs completas y verificadas para compartir con el usuario.
4. **`tinker`**: Para depurar código PHP o consultar modelos Eloquent directamente.
5. **`database-query`**: Para consultas SQL directas de solo lectura a la base de datos.
6. **`browser-logs`**: Para inspeccionar errores de consola y excepciones recientes del navegador.

---

## 📐 4. Reglas de Codificación y Convenciones

### PHP
- **Estructuras de control**: Usa siempre llaves `{ }`, incluso en bloques de una sola línea.
- **Constructores**: Usa *Constructor Property Promotion* de PHP 8 en `__construct()`. No dejes constructores públicos vacíos sin parámetros.
- **Tipado estricto**:
  - Declara tipos de retorno explícitos en todos los métodos y funciones.
  - Declara tipos en todos los parámetros de método.
- **Comentarios**:
  - Prioriza bloques PHPDoc sobre comentarios inline.
  - No uses comentarios dentro del cuerpo de la función salvo para lógica de negocio extremadamente compleja.
  - Añade definiciones de forma de array (*array shapes*) en PHPDoc cuando aplique.
- **Enums**: Nombres de casos en `TitleCase` (ej. `EstadoActuacion`, `TipoContrato`).

### Laravel Core & Eloquent
- **Creación de clases**: Usa generadores Artisan con `--no-interaction`:
  - Clases genéricas: `vendor/bin/sail artisan make:class NombreClase`
  - Modelos con factories/seeders: `vendor/bin/sail artisan make:model Nombre -mfs`
  - Form Requests: `vendor/bin/sail artisan make:request NombreRequest`
- **Base de Datos & Eloquent**:
  - Usa relaciones Eloquent con tipo de retorno definido. Evita consultas crudas `DB::` a favor de `Model::query()`.
  - Evita problemas N+1 mediante eager loading (`with(...)`).
  - Aprovecha la funcionalidad de Laravel 12 para limitar relaciones cargadas ansiosamente (ej: `$query->latest()->limit(10)`).
  - Define atributos en el método `casts()` del modelo en lugar de la propiedad `$casts`.
  - Al modificar columnas en migraciones, incluye siempre todos los atributos previos para evitar que se pierdan.
- **Validación & Controladores**:
  - Valida siempre mediante clases `FormRequest`, nunca con validación inline en controladores.
- **Rutas & Enlaces**:
  - Utiliza rutas con nombre y la función auxiliar `route('nombre.ruta')`.
  - No llames a `env()` fuera de los archivos en `config/`; utiliza siempre `config('app.name')`.
- **Trabajos en Cola**:
  - Implementa la interfaz `ShouldQueue` para cualquier tarea lenta o intensiva.

### Livewire 3
- **Estructura**: Cada componente debe tener un único elemento raíz en su vista Blade.
- **Reactividad**:
  - Usa `wire:model.live` para actualización en tiempo real (`wire:model` es diferido por defecto en Livewire 3).
  - Usa `wire:key="item-{{ $item->id }}"` dentro de bucles `@foreach`.
  - Usa `wire:loading` y `wire:dirty` para indicar estados de carga y cambios pendientes.
- **Espacio de nombres y eventos**:
  - Componentes en el namespace `App\Livewire` (no `App\Http\Livewire`).
  - Para disparar eventos usa `$this->dispatch('evento')` (en lugar de `emit`).
  - Alpine.js viene integrado con Livewire 3; no lo importes manualmente.
- **Layouts**: La ruta típica de layout es `components.layouts.app`.

### Tailwind CSS 3
- Usa utilidades estándar de Tailwind CSS v3.
- Para espaciado en listas o grids, usa utilidades `gap-*` en el contenedor en lugar de márgenes en los hijos.
- Respeta el soporte para modo oscuro (`dark:`) en componentes y vistas existentes.
- Extrae patrones repetidos a componentes reutilizables (Blade / Livewire).

### Testing y Formato
- **PHPUnit 10**: Toda prueba debe ser una clase PHPUnit. **No utilices Pest** (si encuentras sintaxis de Pest, conviértela a PHPUnit).
  - Crear feature test: `vendor/bin/sail artisan make:test --phpunit NombreTest`
  - Crear unit test: `vendor/bin/sail artisan make:test --phpunit --unit NombreTest`
  - Ejecutar test unitario/específico: `vendor/bin/sail artisan test --compact --filter=testName`
  - Ejecutar suite: `vendor/bin/sail artisan test --compact`
- **Laravel Pint**:
  - Antes de finalizar cualquier tarea o cambio, ejecuta el formateador:
    ```bash
    vendor/bin/sail bin pint --dirty
    ```

---

## 👥 5. Agentes de Spec-Kit (`.github/agents/`)

En el directorio [`.github/agents/`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents) se encuentran los agentes especializados del framework Spec-Kit para el desarrollo guiado por especificaciones (SDD):

| Agente | Fichero | Propósito |
| :--- | :--- | :--- |
| **Specify** | [`speckit.specify.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.specify.agent.md) | Genera especificaciones detalladas de requisitos a partir de necesidades del usuario. |
| **Clarify** | [`speckit.clarify.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.clarify.agent.md) | Identifica y resuelve ambigüedades en especificaciones y casos borde. |
| **Constitution** | [`speckit.constitution.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.constitution.agent.md) | Mantiene y aplica los principios fundamentales y la constitución arquitectónica. |
| **Checklist** | [`speckit.checklist.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.checklist.agent.md) | Crea listas de verificación y criterios de aceptación para especificaciones. |
| **Plan** | [`speckit.plan.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.plan.agent.md) | Diseña planes de implementación técnica y arquitectura de la solución. |
| **Tasks** | [`speckit.tasks.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.tasks.agent.md) | Descompone el plan técnico en tareas de implementación granulares. |
| **Tasks to Issues** | [`speckit.taskstoissues.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.taskstoissues.agent.md) | Convierte las tareas definidas en incidencias (*GitHub Issues*). |
| **Implement** | [`speckit.implement.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.implement.agent.md) | Ejecuta las tareas del plan de implementación y realiza los cambios de código. |
| **Converge** | [`speckit.converge.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.converge.agent.md) | Valida la convergencia del código implementado contra los requisitos. |
| **Analyze** | [`speckit.analyze.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.analyze.agent.md) | Analiza consistencia y coherencia entre requisitos, diseño y código. |
| **Brownfield Scan** | [`speckit.brownfield.scan.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.brownfield.scan.agent.md) | Escanea la arquitectura y convenciones de este proyecto existente. |
| **Brownfield Bootstrap**| [`speckit.brownfield.bootstrap.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.brownfield.bootstrap.agent.md) | Inicializa la configuración de Spec-Kit adaptada a este repositorio. |
| **Brownfield Migrate** | [`speckit.brownfield.migrate.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.brownfield.migrate.agent.md) | Aplica ingeniería inversa y adopción progresiva de SDD para funcionalidades existentes. |
| **Brownfield Validate**| [`speckit.brownfield.validate.agent.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/agents/speckit.brownfield.validate.agent.md) | Valida que la configuración generada coincida fielmente con la realidad del proyecto. |

---

## 🧰 6. Habilidades del Proyecto (`.agents/skills/`)

En el directorio [`.agents/skills/`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.agents/skills) se encuentran las habilidades configuradas para asistir a los agentes:

1. **[`pwa-development`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.agents/skills/pwa-development/SKILL.md)**:
   - Construcción y mantenimiento de la PWA (Progressive Web App).
   - Gestión de *Service Workers*, estrategias de cache (CacheFirst, NetworkFirst, StaleWhileRevalidate), modo offline y Workbox.
   - Sincronización con el `ManifestService` y `manifest.json`.
2. **[`speckit-brownfield-scan`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.agents/skills/speckit-brownfield-scan/SKILL.md)**:
   - Detección automática de la arquitectura, dependencias y patrones de la aplicación.
3. **[`speckit-brownfield-bootstrap`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.agents/skills/speckit-brownfield-bootstrap/SKILL.md)**:
   - Generación de configuraciones a medida de Spec-Kit para el código existente.
4. **[`speckit-brownfield-migrate`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.agents/skills/speckit-brownfield-migrate/SKILL.md)**:
   - Migración incremental y generación inversa de especificaciones para módulos ya desarrollados.
5. **[`speckit-brownfield-validate`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.agents/skills/speckit-brownfield-validate/SKILL.md)**:
   - Verificación de consistencia entre las definiciones de bootstrap y las convenciones del código.

---

## 🔄 7. Flujo de Trabajo Recomendado para Agentes

Al recibir una tarea en este repositorio, el agente debe seguir este ciclo:

```
1. Explorar & Consultar
   ├── Revisar sibling files para convenciones existentes
   └── Consultar docs con Boost: search-docs ['tema']

2. Implementar
   ├── Usar generadores Artisan vía Sail: vendor/bin/sail artisan make:...
   ├── Respetar tipos estrictos PHP 8, Form Requests y Livewire 3
   └── Reutilizar componentes Blade / Livewire existentes

3. Probar & Verificar
   ├── Ejecutar tests con PHPUnit: vendor/bin/sail artisan test --compact --filter=NombreTest
   └── En cambios visuales, compilar assets: vendor/bin/sail npm run build

4. Dar Formato & Finalizar
   └── Ejecutar Pint: vendor/bin/sail bin pint --dirty
```

---

## 📚 Referencias Adicionales

- Instrucciones de GitHub Copilot originales: [`.github/copilot-instructions.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/.github/copilot-instructions.md)
- Documentación general de la aplicación: [`README.md`](file:///c:/Users/pable/Documents/Webs/eBand/eBand/README.md)

