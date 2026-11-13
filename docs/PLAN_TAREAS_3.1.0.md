# Plan de Tareas: eBand 3.1.0 (Dark Command Center Responsivo)

Este documento define la hoja de ruta de implementación técnica para la versión **3.1.0** de eBand, basada en el sistema de diseño [`DESIGN.md`](../DESIGN.md) y en el [`PROMPT_MAESTRO_3.1.0.md`](./PROMPT_MAESTRO_3.1.0.md).

---

## Metodología de Trabajo: Vertical Slices

Cada pantalla se aborda de extremo a extremo (Frontend Blade/Livewire + adaptaciones de lógica Eloquent) respetando la compatibilidad de base de datos y la arquitectura responsiva (**Móvil < 768px** vs **Escritorio >= 1024px**).

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│  FASE 1: Cimientos & Shell (Tailwind tokens + Sidebar Desktop + BottomNav)     │
├─────────────────────────────────────────────────────────────────────────────────┤
│  FASE 2: Vertical Slice 1 — Dashboard "Inicio - Panel del Músico"               │
├─────────────────────────────────────────────────────────────────────────────────┤
│  FASE 3: Vertical Slice 2 — Actuaciones, Ensayos y Asistencia (Master-Detail)  │
├─────────────────────────────────────────────────────────────────────────────────┤
│  FASE 4: Vertical Slice 3 — Directorio de Músicos y Cuerdas                    │
├─────────────────────────────────────────────────────────────────────────────────┤
│  FASE 5: Vertical Slice 4 — Ficha de Músico, Perfil e Inventario               │
├─────────────────────────────────────────────────────────────────────────────────┤
│  FASE 6: Vertical Slice 5 — Liquidaciones y Reparto Económico de Bolos         │
├─────────────────────────────────────────────────────────────────────────────────┤
│  FASE 7: Verificación, Testing PHPUnit y Pulido PWA                            │
└─────────────────────────────────────────────────────────────────────────────────┘
```

---

## 🧱 Fase 1: Cimientos y Layout Shell Responsivo (Infraestructura UI)

- [x] **Tarea 1.1: Integrar Tokens de `DESIGN.md` en Tailwind** *(Completada - Commit f7b08eb)*
  - Mapear la paleta *Dark Command Center* en `tailwind.config.js` (`surface: #0B1120`, `surface-card: #111827`, `primary: #2563EB`, `secondary: #F59E0B`, estados de asistencia).
  - Configurar las tipografías `Plus Jakarta Sans` e `Inter` e importar fuentes en el layout.
- [x] **Tarea 1.2: Componentes Blade Base Atómicos** *(Completada - Commit 13043e0)*
  - `<x-ui.card>`: Contenedor con fondo `#111827`, borde `#1E293B` y radio `rounded-xl`/`rounded-2xl`.
  - `<x-ui.button>`: Variantes primaria (azul eléctrico), secundaria (latón/ámbar), de éxito, peligro y ghost.
  - `<x-badge-status>`: Píldoras semánticas para *Disponible*, *Duda* y *No disponible*.
- [x] **Tarea 1.3: Layout Shell Responsivo Unificado (`layouts/app.blade.php`)** *(Completada - Commit 13043e0)*
  - **Móvil (`< 768px`):** Top Bar fija con selector de banda compacto + `<x-bottom-nav>` flotante con `backdrop-blur-xl` y soporte `pb-safe`.
  - **Escritorio (`>= 1024px`):** `<x-desktop-sidebar>` lateral izquierda (logo, navegación modular, perfil) + Top Header con breadcrumbs y alertas.

---

## 📱 Fase 2: Vertical Slice 1 — Dashboard (Inicio / Panel del Músico)

- [x] **Tarea 2.1: Lógica de Asistencia y Quórum en Livewire** *(Completada - Commit dc9bae3)*
  - Conmutador de asistencia reactivo con 3 estados (*Assistiré*, *Dubte*, *No vaig*) sincronizado vía AJAX a `/listauserdisp`.
  - Cálculo de quórum de cuerda y metal en la próxima actuación (músicos confirmados vs convocados).
- [x] **Tarea 2.2: Métricas y Feed de Comunicados** *(Completada - Commit dc9bae3)*
  - Cálculo del porcentaje de asistencia del mes en curso y actuaciones activas.
  - Cargar los últimos avisos desde el modelo `Announcement.php` con enlace de acción.
- [x] **Tarea 2.3: Vista Blade Responsiva del Dashboard** *(Completada - Commit dc9bae3)*
  - Móvil: Flujo vertical continuo en una sola columna con cabecera y tarjetas táctiles.
  - Escritorio: Organización en *Bento Grid* de 3 columnas (Hero de próxima actuación en 2 columnas, avisos y métricas en columna lateral, accesos rápidos en rejilla de 6 columnas).

---

## 📅 Fase 3: Vertical Slice 2 — Actuaciones, Calendario y Detalle de Bolo (Completada)

- [x] **Tarea 3.1: Calendario y Listado de Actuaciones**
  - Tarjetas de bolo en móvil con etiquetas de festividad y localización (`resources/views/actuaciones/view-listas.blade.php`).
  - Dark Command Center con chips de filtrado rápido por tipo y población, selector de fecha y rejilla responsive 1-3 columnas.
- [x] **Tarea 3.2: Detalle de Actuación y Control de Asistencia**
  - Vista *Master-Detail* en escritorio (5 cols info/quórum/mapa + 7 cols roster de cuerdas y chat interactivo) en `resources/views/actuaciones/detalles-actuacion.blade.php`.
  - Botonera flotante inferior Dark Command Center con conmutador de disponibilidad táctil de alto contraste y soporte AJAX/Livewire intacto.

---

## 👥 Fase 4: Vertical Slice 3 — Directorio de Músicos y Cuerdas (Completada)

- [x] **Tarea 4.1: Vista Móvil:** Tarjetas táctiles y compactas con avatar, instrumento, badges de estado y accesos rápidos a estadísticas y edición (`resources/views/users/index.blade.php`).
- [x] **Tarea 4.2: Vista Escritorio:** Tabla densa de alto contraste con buscador, filtro de instrumentos y estados, modal de exportación Dark Command Center y gráfico de cuerdas adaptado (`<x-statistics.instruments />`).

---

## 💶 Fase 5: Vertical Slice 4 — Liquidaciones y Reparto de Bolos

- [ ] **Tarea 5.1:** Panel de liquidaciones con saldo acumulado y resumen de pagos (`specs/payments`).
- [ ] **Tarea 5.2:** Desglose por bolo y kilometraje adaptado al tema oscuro.

---

## 🎺 Fase 6: Vertical Slice 5 — Inventario, Material y Ficha de Músico

- [ ] **Tarea 6.1:** Vista de material asignado (instrumento prestado, boquillas, uniformes).
- [ ] **Tarea 6.2:** Ficha de perfil de músico (datos de contacto, talla de uniforme, cuerdas).

---

## 🧪 Fase 7: Validación, Tests y Formateo

- [ ] **Tarea 7.1:** Ejecución de tests automatizados con PHPUnit (`vendor/bin/sail artisan test --compact`).
- [ ] **Tarea 7.2:** Formateador de código con Laravel Pint (`vendor/bin/sail bin pint --dirty`).
- [ ] **Tarea 7.3:** Verificación PWA en dispositivos móviles y de escritorio.
