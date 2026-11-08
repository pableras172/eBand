# Mobile Web UX Guidelines (Capacitor)
- **Safe Area Insets:** Always account for notches and home indicators. Use Tailwind's `pt-[env(safe-area-inset-top)]` and `pb-[env(safe-area-inset-bottom)]` on main layouts.
- **Touch Targets:** Ensure all buttons and clickable elements have a minimum target size of 44x44px or 48x48px (`min-h-[48px]`).
- **Web Disables:** Prevent unwanted web behaviors in mobile viewports. Apply `select-none` (user-select: none) to non-text elements and `touch-manipulation` to eliminate double-tap delays.
- **Scroll Optimization:** Use `overflow-y-auto scrolling-touch` for fluid, native-like scrolling momentum on iOS containers.
