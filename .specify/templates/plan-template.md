# Implementation Plan: [FEATURE]

**Branch**: `[###-feature-name]` | **Date**: [DATE] | **Spec**: [link]

**Input**: Feature specification from `/specs/[###-feature-name]/spec.md`

## Summary

[Summarize the requested change in the context of the existing Laravel app, including the primary routes, Livewire screens, models, or services involved.]

## Technical Context

**Language/Version**: PHP 8.3 / Laravel 13 / Livewire 4 / Tailwind CSS 3 / Vite

**Primary Dependencies**: Laravel Jetstream, Sanctum, Cashier, Pulse, Livewire, DomPDF, Excel, PWA assets

**Storage**: Existing Laravel database with Eloquent models, migrations, factories, and seeders

**Testing**: PHPUnit feature and unit tests under `tests/Feature` and `tests/Unit`

**Target Platform**: Laravel web application served through Sail, with browser UI and PWA support

**Project Type**: Monolithic web application

**Performance Goals**: Preserve current response characteristics for authenticated flows and avoid introducing expensive queries without eager loading

**Constraints**: Must respect existing auth, demo read-only, and admin middleware; must work with the current Laravel 10-style directory layout preserved in this repo

**Scale/Scope**: Feature-level changes within the current monolith, usually touching a small number of controllers, Livewire components, views, models, and tests

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

[Summarize any constitution checks relevant to the feature.]

## Project Structure

### Documentation (this feature)

```text
feature-directory/
├── plan.md
├── research.md
├── data-model.md
├── quickstart.md
├── contracts/
└── tasks.md
```

### Source Code (repository root)

```text
app/
├── Http/Controllers/
├── Livewire/
├── Models/
├── Services/
├── Jobs/
├── Notifications/
├── Policies/
└── View/Components/

database/
├── migrations/
├── factories/
└── seeders/

resources/
├── views/
├── css/
└── js/

routes/
├── web.php
├── api.php
└── console.php

tests/
├── Feature/
└── Unit/

public/
├── manifest.json
├── sw.js
└── offline.html
```

**Structure Decision**: Implement the feature inside the existing Laravel monolith, using the smallest combination of controllers, Livewire components, models, and views needed for the feature slice.

## Implementation Notes

- Prefer existing route groups and middleware from `routes/web.php`.
- Prefer existing Livewire patterns in `app/Livewire` before introducing a new controller.
- If the feature needs data changes, include the migration, factory, and test updates in the same plan.
- If the feature affects browser behavior, account for the Vite/Tailwind build path and any PWA assets under `public/`.

## Complexity Tracking

Use this only if the feature requires a deliberate deviation from an existing project rule.

| Violation | Why Needed | Simpler Alternative Rejected Because |
|-----------|------------|-------------------------------------|
| [Example deviation] | [current need] | [why the simpler option is insufficient] |
