# eBand Constitution

## Core Principles

### I. Laravel-First Monolith
The application is a single Laravel web app, not a multi-service architecture. New behavior belongs in the existing Laravel layers: controllers in `app/Http/Controllers`, Livewire components in `app/Livewire`, models in `app/Models`, reusable business logic in `app/Services`, and jobs/listeners/notifications where appropriate.

### II. UI Lives in Blade and Livewire
User-facing screens are primarily rendered with Blade views and Livewire components. Prefer `Route::livewire(...)` or existing Blade views over adding a separate frontend framework. Reuse the layout components in `app/View/Components` and the views under `resources/views`.

### III. Test the Feature Slice
Changes should be covered by PHPUnit tests in `tests/Feature` or `tests/Unit` as appropriate. For user-facing flows, prefer feature tests that exercise the actual route, Livewire interaction, or controller behavior.

### IV. Preserve Existing Routing and Authorization
Route organization follows `routes/web.php` and `routes/api.php`, with middleware, rate limits, and authorization checks enforced through Laravel features already present in the repo. Respect guards, policies, `can:` checks, and custom middleware such as the demo read-only and active-user constraints already wired into the app.

### V. Keep Business Logic Out of Views
Views should remain presentation-focused. Domain rules, transformations, and side effects belong in controllers, services, jobs, listeners, or model methods. If logic is reused across screens, extract it into the smallest existing reusable layer rather than duplicating it in Blade or Livewire components.

## Project Boundaries

- Backend HTTP entry points live in `routes/web.php` and `routes/api.php`.
- Controllers live in `app/Http/Controllers` and should handle request orchestration, validation handoff, and response selection.
- Livewire components live in `app/Livewire`, grouped by feature area such as `Actuaciones`, `Inventory`, `Payment`, `Suggestions`, and `Configuration`.
- Eloquent models live in `app/Models`; factories, migrations, and seeders live in `database/factories`, `database/migrations`, and `database/seeders`.
- Shared services and cross-cutting integrations live in `app/Services`.
- Blade views live in `resources/views`; reusable layout components live in `app/View/Components`.
- Frontend assets are built with Vite and Tailwind CSS from `resources/js`, `resources/css`, `package.json`, and `vite.config.js`.
- PWA assets and offline behavior live in `public/manifest.json`, `public/sw.js`, and `public/offline.html`.

## Naming and Style Conventions

- Use PascalCase for classes, Livewire components, models, policies, jobs, and notifications.
- Use snake_case for migration filenames and database columns when matching Laravel conventions.
- Branch names are release/version oriented in this repo, such as `2.0.0` and `3.0.0`; do not assume a `feat/*` or `fix/*` prefix convention unless the team explicitly adopts one.
- Keep route names descriptive and consistent with existing patterns such as `concert-programs.public`, `inventory.export.pdf`, and `notifications.read`.
- Keep feature folders aligned with the current domain structure already used in `app/Livewire` and `resources/views`.
- Follow `.editorconfig`: UTF-8, LF line endings, 4-space indentation for code, and 2-space indentation in YAML.
- Commit messages in this repo are short and descriptive, often in Spanish; do not force a new commit style unless the team agrees to it.

## Testing Requirements

- Use PHPUnit for all tests.
- Prefer feature tests for routes, Livewire pages, authentication, authorization, exports, and other user-visible behavior.
- Keep unit tests for pure domain logic or small isolated services.
- Add or update tests alongside behavioral changes; do not leave important route or permissions changes untested.
- Existing tests live in `tests/Feature` and `tests/Unit`; follow the current naming pattern with `*Test.php` files.

## Dependency and Tooling Rules

- The current declared stack is PHP 8.3, Laravel 13, Livewire 4, Jetstream 5, Sanctum 4, Cashier 16, Pulse 1, and Tailwind CSS 3.
- Use Sail for PHP, Composer, Artisan, and Node commands when validating changes in this environment.
- Use Composer and npm only through the repo's existing workflow; do not introduce new package managers or build systems without a clear need.
- Prefer Laravel-native features before external packages when the repo already has a built-in path for the task.

## Quality Gates

- Run the relevant PHPUnit tests for the touched area before considering the change complete.
- Run Pint on dirty files before finishing a code change.
- If a change affects frontend output, verify the Vite/Tailwind build path used by the app.
- Keep changes compatible with the current Laravel 10-style project layout preserved in this repo.

## Governance

This constitution governs spec-kit outputs for the repository and takes precedence over generic templates. Amendments should only be made when the codebase convention actually changes. Any new rule must be traceable to an existing project pattern or an explicit team decision.

**Version**: 1.0.0 | **Ratified**: 2026-07-17 | **Last Amended**: 2026-07-17
