# Design System: eBand - Dark Command Center
**Project ID:** 147458596168789549

---

## 1. Visual Theme & Atmosphere

The **eBand Dark Command Center** design system establishes a focused, high-contrast, professional operational environment tailored for musical ensembles (bands, marching bands, charangas, orchestras, and choirs). 

Musicians and band directors operate in visually challenging environments: dim rehearsal spaces, dark concert stages, night festivals (*pasacalles*, *moros y cristianos*, patron saint festivities), and harsh sunlight. The Dark Command Center theme cuts through visual fatigue with an **obsidian-slate canvas**, luminous **royal blue interactive affordances**, and **warm instrument-brass accents**.

The aesthetic evokes a **tactile control station**: structured data cards with crisp borders, glowing status indicators, translucent glassmorphic navigation bars, and instant, haptic-friendly attendance controls.

### Key Characteristics
- **Deep Obsidian Canvas (`#0B1120`)**: Eliminates white-screen glare during night performances and saves battery on mobile OLED screens.
- **Glassmorphic Navigation**: Header and navigation bars float with `backdrop-blur-xl` and 90% opacity, grounding content without hiding context.
- **Luminous Interactive Accents (`#2563EB` & `#F59E0B`)**: Interactive elements, active tabs, and priority badges emit soft ambient glows.
- **Micro-State Attendance Clarity**: Instant visual distinction between confirmed presence, doubts, and absences with semantically tinted pill containers.
- **Responsive Symmetry**: Built mobile-first for fast one-thumb tap interactions on stage, while scaling seamlessly to dense, multi-column desktop dashboards.

---

## 2. Color Palette & Functional Roles

### Surface & Canvas Architecture
- **Obsidian Deep Slate (`#0B1120`)** — `surface`, `surface-page`: The base canvas for the entire application. Deep and immersive without being pure black.
- **Midnight Card Surface (`#111827`)** — `surface-card`: Used for modular cards, upcoming gig containers, and notice blocks.
- **Elevated Slate Container (`#1E293B`)** — `surface-container`: For nested modules, metric bars, and secondary container layers.
- **High Slate Highlight (`#334155`)** — `surface-container-high`: Hover states, active pressed states, and prominent dividers.
- **Recessed Dark Well (`#0F172A`)** — `surface-container-low`: Inset backgrounds for toggle switches and secondary inputs.

### Brand & Interactive Accents
- **Electric Royal Blue (`#2563EB`)** — `primary`: Primary calls to action, selected navigation states, interactive icons, and focus rings.
- **Deep Royal Blue (`#1D4ED8`)** — `primary-fixed`: Pressed states for primary buttons and high-emphasis action triggers.
- **Instrument Brass Amber (`#F59E0B`)** — `secondary`: Warm accent evoking polished brass instruments. Used for musical notes, announcements, downloads, and notice badges.
- **Burnished Amber (`#D97706`)** — `secondary-container`: Supporting borders and badge fills for featured achievements.

### Semantic Attendance Indicators (Core UX)
- **Confirmado / Asistiré (`#10B981`)** — `status-available`: Emerald green for confirmed attendance and verified quorum metrics.
  - Subtly tinted container: `rgba(16, 185, 129, 0.15)` — `status-available-subtle`.
- **Duda / Pendiente (`#F59E0B`)** — `status-pending`: Warm amber for unconfirmed attendance or pending actions.
  - Subtly tinted container: `rgba(245, 158, 11, 0.15)` — `status-pending-subtle`.
- **No Asistiré / Ausente (`#F43F5E`)** — `status-unavailable`: Rose red for confirmed absence or rejected convocations.
  - Subtly tinted container: `rgba(244, 63, 94, 0.15)` — `status-unavailable-subtle`.
- **Error Crítico (`#EF4444`)** — `error`: Validation errors and emergency notifications.

### Text & Typographic Hierarchy
- **Pure White Slate (`#F8FAFC`)** — `on-surface`: Primary headings, event titles, and critical metrics.
- **Slate Light Gray (`#94A3B8`)** — `on-surface-variant`: Subtitles, event locations, timestamps, and secondary labels.
- **Slate Muted (`#64748B`)** — `outline`: Inactive icons, subtle structural borders, and placeholder text.
- **Subtle Dark Border (`#1E293B`)** — `border-subtle`: 1px hairline border separating cards and modules.

---

## 3. Typography Rules

### Font Families
- **Headlines & Titles:** `Plus Jakarta Sans` — Rounded geometric sans-serif that balances modern digital precision with inviting musical warmth.
- **Body & Labels:** `Inter` — Neutral, tall x-height workhorse delivering maximum legibility on stage, outdoors, and across varying screen sizes.

### Typographic Scale & Weights
| Token | Font Family | Size | Line Height | Letter Spacing | Weight | Role |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **`display-lg`** | Plus Jakarta Sans | 36px | 44px | -0.02em | 800 (Extrabold) | Hero figures, platform title |
| **`headline-lg`** | Plus Jakarta Sans | 30px | 38px | -0.015em | 700 (Bold) | Desktop page titles |
| **`headline-lg-mobile`**| Plus Jakarta Sans | 24px | 32px | -0.01em | 700 (Bold) | Mobile dashboard greeting |
| **`headline-md`** | Plus Jakarta Sans | 20px | 28px | -0.01em | 700 (Bold) | Event titles, metric values |
| **`headline-sm`** | Plus Jakarta Sans | 18px | 24px | Normal | 600 (Semibold) | Section headers ("Próxima Actuación") |
| **`body-lg`** | Inter | 16px | 24px | Normal | 400 (Regular) | Primary content, long descriptions |
| **`body-md`** | Inter | 14px | 20px | Normal | 400 (Regular) | Standard body text, announcements |
| **`body-sm`** | Inter | 12px | 16px | Normal | 400 (Regular) | Timestamps, locations, voice/instrument |
| **`label-lg`** | Inter | 14px | 20px | 0.01em | 600 (Semibold) | Buttons, attendance switch labels |
| **`label-md`** | Inter | 12px | 16px | 0.02em | 600 (Semibold) | Badges, band selector button |
| **`label-sm`** | Inter | 11px | 14px | 0.04em | 700 (Bold) | Status chips, tags, quorum pills |

---

## 4. Geometry, Radii & Spacing

### Border Radius Hierarchy
- **Base / Inputs (`0.25rem` / `rounded-sm`)**: Form controls, text inputs, segmented toggle buttons.
- **Subtle Rounded (`0.5rem` / `rounded-lg`)**: Secondary buttons, dropdown items, filter chips.
- **Card Radius (`0.75rem` / `rounded-xl`)**: Quick-access shortcut tiles, announcement cards, metric boxes.
- **Major Module Radius (`1.0rem` / `rounded-2xl`)**: Event hero card, metric command bar, modal wrappers.
- **Pill Silhouette (`9999px` / `rounded-full`)**: Attendance status badges, instrument chips, user avatars, action triggers.

### Spacing Scale
- `space-xs`: `0.25rem` (4px) — Icon and label gaps
- `space-sm`: `0.5rem` (8px) — Card internal clusters, chip padding
- `space-md`: `0.75rem` (12px) — Section gaps, list row padding
- `space-lg`: `1.0rem` (16px) — Card padding, mobile outer margins
- `space-xl`: `1.5rem` (24px) — Section separation, desktop gutters
- `space-2xl`: `2.0rem` (32px) — Major view divisions, desktop outer margins

---

## 5. Core Component Stylings

### 1. Segmented Attendance Switcher
The most important interactive component for performing musicians.
- **Container**: `grid grid-cols-3 gap-1.5 p-1.5 bg-[#0F172A] border border-[#1E293B] rounded-xl`.
- **Buttons**:
  - `Asistiré`: Solid `#10B981` (Emerald), text `#ffffff`, shadow `0 4px 12px rgba(16, 185, 129, 0.3)`.
  - `Duda`: Solid `#F59E0B` (Amber), text `#ffffff`, shadow `0 4px 12px rgba(245, 158, 11, 0.3)`.
  - `No voy`: Solid `#F43F5E` (Rose), text `#ffffff`, shadow `0 4px 12px rgba(244, 63, 94, 0.3)`.
  - Unselected state: Text `#94A3B8`, background transparent, hover `bg-slate-800/60`.

### 2. Hero Event Card ("Próxima Actuación")
- **Structure**: Rounded 16px (`rounded-2xl`), border `1px solid #1E293B`, background `linear-gradient(to bottom, #111827, #0B1120)`.
- **Media Header**: 144px height image with a dark gradient fade overlay (`from-[#111827] via-[#111827]/40 to-transparent`).
- **Floating Badges**: Pill-shaped with backdrop blur (`Obligatorio`, `Fiestas Patronales`, location).
- **Quorum Indicator**: Pill box showing confirmed musician count (e.g., `42/48 Músicos confirmados`).

### 3. Metric-First Command Center Bar
- **Container**: Dual-card grid (`grid grid-cols-2 gap-2`) with subtle dark gradient and border `1px solid #1E293B`.
- **Metrics**: Extrabold numbers (`headline-md`) paired with status icons and pill tags (`Este mes`, `Activos`).

### 4. Quick Access Grid
- **Layout**: 3 columns on mobile, expanding to 6 columns on desktop.
- **Card**: Square-ish card with 12px padding, centered icon in colored tint container (`w-10 h-10 rounded-xl bg-blue-600/15`), followed by bold title and small subtext.

### 5. Status Badges & Chips
- **Disponible**: `bg-emerald-500/15 text-emerald-400 border border-emerald-500/20`.
- **Duda**: `bg-amber-500/15 text-amber-400 border border-amber-500/20`.
- **No disponible**: `bg-rose-500/15 text-rose-400 border border-rose-400/20`.
- **Instrument / Section Tag**: `bg-slate-800 text-slate-300 border border-slate-700`.

---

## 6. Responsive Architecture (Móvil vs. Escritorio)

### Breakpoints & Shell Behavior
```
┌─────────────────────────────────────────────────────────────┐
│  Mobile (< 768px):                                          │
│  Fixed Top Bar ➔ Single Column Stream ➔ Bottom Nav Bar       │
├─────────────────────────────────────────────────────────────┤
│  Desktop (>= 1024px):                                       │
│  [ Collapsible Sidebar ]  [ Top App Bar + Breadcrumbs ]     │
│                           [ 12-Column Responsive Workspace ]│
└─────────────────────────────────────────────────────────────┘
```

| Elemento | Móvil (`< 768px`) | Escritorio / Tablet (`>= 1024px`) |
| :--- | :--- | :--- |
| **Navegación** | *Bottom Navigation Bar* fija con blur (`pb-safe`) | *Sidebar* colapsable lateral a la izquierda |
| **Layout Shell** | Flujo vertical en columna única (`px-4`) | Rejilla de 12 columnas con `max-w-7xl` y `px-8` |
| **Listas de Actuaciones**| Tarjetas completas con scroll vertical | Tabla de datos con ordenación + panel lateral de detalle (*Master-Detail*) |
| **Panel de Asistencia** | Botones táctiles grandes en cada tarjeta | Columna interactiva o matriz de cuerdas por secciones |
| **Diálogos / Acciones** | *Bottom Sheet* deslizable desde abajo | Modal centrado con fondo atenuado (`backdrop-blur-sm`) |
| **Acciones Principales** | Barra pegada inferior o botón flotante | Botonera de herramientas en la cabecera superior |
