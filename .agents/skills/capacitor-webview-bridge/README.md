# Capacitor 6 Bridge Guidelines
- **Plugin Imports:** Always check for `@capacitor/core` and specific plugins (e.g., `@capacitor/status-bar`, `@capacitor/device`).
- **Livewire Integration:** When a native feature is triggered (e.g., Camera), capture the result in JS via Capacitor API and pass it to Livewire using `Livewire.dispatch('event-name', { data })`.
- **Platform Detection:** Use `Capacitor.getPlatform()` to conditionally render specific styling or behaviors for 'ios' vs 'android'.
