# eBand 3.1.0 - Plataforma de Gestión Musical y Operativa (Dark Command Center)

Una aplicación web progresiva (PWA) de alto rendimiento y grado profesional diseñada para bandas de música, orquestas, agrupaciones y charangas. Ofrece una experiencia de "Command Center" inmersiva, táctil y de alto contraste, optimizada tanto para smartphones en escenarios y desfiles nocturnos como para escritorios y tabletas en tareas directivas y administrativas.

---

### DESIGN SYSTEM & DESIGN TOKENS (REQUIRED)

- **Plataforma:** Web PWA, arquitectura simétrica (Mobile-First + Expansión Desktop de 12 columnas).
- **Tema Visual:** Dark Command Center — estético, profesional, libre de fatiga visual, con superficies de pizarra oscura, luces de acento y feedback táctil.
- **Paleta de Color:**
  - Base Canvas (`surface-page`): Obsidian Deep Slate (`#0B1120`)
  - Tarjetas y Módulos (`surface-card`): Midnight Deep Card (`#111827`) con borde sutil (`#1E293B`)
  - Contenedores Elevados (`surface-container`): Slate Container (`#1E293B`)
  - Acento Primario (`primary`): Electric Royal Blue (`#2563EB`) para acciones primarias, pestañas activas y focos
  - Acento Secundario (`secondary`): Warm Brass Amber (`#F59E0B`) evocando el metal de los instrumentos para avisos, partituras y notas
  - Superficies de Navegación: Glassmorphism translúcido con `backdrop-blur-xl` y `bg-[#0B1120]/90`
- **Estados Semánticos de Asistencia:**
  - Confirmado / Asistiré: Emerald Green (`#10B981`) con contenedor tenue (`rgba(16, 185, 129, 0.15)`)
  - Duda / Pendiente: Warm Amber (`#F59E0B`) con contenedor tenue (`rgba(245, 158, 11, 0.15)`)
  - No asistiré / Ausente: Rose Red (`#F43F5E`) con contenedor tenue (`rgba(244, 63, 94, 0.15)`)
- **Tipografía:**
  - Titulares, Métricas y Nombres de Banda: `Plus Jakarta Sans` (pesos 600, 700 y 800)
  - Textos de Cuerpo, Tablas, Chips y Formularios: `Inter` (pesos 400, 500 y 600)
  - Color de Texto Primario: Pure White Slate (`#F8FAFC`)
  - Color de Texto Secundario: Slate Muted (`#94A3B8`)
- **Geometría y Radios:**
  - Píldoras (`rounded-full`): Conmutadores de asistencia, badges de instrumentos/cuerdas, tags de sección y avatares
  - Tarjetas medianas y atajos: `rounded-xl` (12px)
  - Módulos maestros y tarjetas hero: `rounded-2xl` (16px)

---

### ARQUITECTURA RESPONSIVE (MÓVIL VS. ESCRITORIO)

1. **En Móvil (< 768px):**
   - **Header:** Fijo superior (`h-16`), logo `eBand`, selector de banda compacto y campana de avisos.
   - **Navegación:** *Bottom Navigation Bar* fija flotante con 4 accesos directos (*Inicio, Actuaciones, Músicos, Gestión*) y soporte de área segura (`pb-safe`).
   - **Layout:** Flujo continuo vertical en columna única (`px-4`, `gap-4`).
   - **Interacciones:** Diálogos en formato *Bottom Sheet* táctil deslizable desde abajo.

2. **En Escritorio / Tablet (>= 1024px):**
   - **Navegación:** *Sidebar* lateral izquierda colapsable con logotipo completo, selector de banda, navegación por secciones con iconos y perfil de usuario inferior.
   - **Cabecera de Trabajo:** Barra superior con migas de pan (*breadcrumbs*), barra de búsqueda global y notificaciones.
   - **Layout:** Rejilla flexible de 12 columnas (`max-w-7xl`, `px-8`, `gap-6`).
   - **Vistas Adaptadas:**
     - El Dashboard organiza métricas y avisos en un *Bento Grid* modular de 3 columnas.
     - Las listas pasan de tarjetas verticales a **tablas de datos densas con filtros por cuerda** y vista *Master-Detail* a dos columnas (listado a la izquierda, detalle a la derecha).

---

### ESTRUCTURA DE LA PANTALLA PRINCIPAL (DASHBOARD - PANEL DEL MÚSICO)

1. **Módulo de Saludo y Perfil:**
   - Avatar del músico con aro de acento y badge de instrumento (ej: "Trompeta 1ª · Montaverner").
   - Saludo dinámico con titular `Plus Jakarta Sans` y acceso rápido a "Mi Perfil".
2. **Barra de Mando de Métricas (Command Bar):**
   - Tarjetas métricas gemelas: Porcentaje de asistencia mensual (ej: "94%") y ensayos activos (ej: "4").
3. **Tarjeta Hero: "Próxima Actuación":**
   - Cabecera visual con foto de la localidad/evento y degradado oscuro.
   - Píldoras flotantes: "Obligatorio" (rojo), "Fiestas Patronales" (slate), "Ontinyent (Valencia)".
   - Fecha y hora destacadas en azul eléctrico.
   - Indicador de Quórum en tiempo real: "42/48 Músicos confirmados".
   - **Conmutador de Asistencia:** Selector táctil integrado con feedback visual instantáneo (*Asistiré / Duda / No voy* o *Disponible / No disponible*).
4. **Tablón de Últimos Avisos de Dirección:**
   - Tarjeta interactiva conectada al modelo de comunicados (`announcements`).
   - Indicador de emisor ("Dirección Musical"), tiempo transcurrido, extracto y botón de acción (ej: "Descargar partituras").
5. **Rejilla de Accesos Rápidos:**
   - 3 columnas en móvil / 6 columnas en desktop:
     - 📂 *Mis Partituras* (Archivo digital)
     - 🎺 *Mi Instrumento* (Inventario asignado, fundas, accesorios)
     - 👨‍👩‍👧 *Educandos / Familia* (Control parental para menores)
6. **Cita / Frase del Ensayo:**
   - Módulo inspirador sutil con icono ámbar de cita musical.
