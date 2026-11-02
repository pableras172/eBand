# Especificación de la Feature: Mapa de ubicaciones

**Feature Branch**: `[location-map]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/LocationMap.php` y `resources/views/livewire/location-map.blade.php`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Visualizar un mapa interactivo de ubicaciones (Prioridad: P1)

Como usuario de la aplicación, quiero ver un mapa interactivo para consultar ubicaciones relacionadas con actuaciones, contratos o la pantalla de bienvenida.

**Por qué esta prioridad**: el mapa es una pieza visual reutilizada en varias pantallas y aporta valor inmediato de contexto geográfico.

**Prueba independiente**: abrir una pantalla que monte el componente y comprobar que el mapa se carga con su altura configurada y muestra marcadores cuando hay municipios.

**Escenarios de aceptación**:

1. **Dado** que se monta el componente, **cuando** se renderiza, **entonces** aparece un contenedor de mapa con la altura indicada.
2. **Dado** que el backend pasa municipios iniciales, **cuando** se inicializa la vista, **entonces** se pintan marcadores sobre el mapa.
3. **Dado** que no hay municipios iniciales, **cuando** se carga el mapa, **entonces** se muestra una vista por defecto centrada.

---

### Historia de usuario 2 - Añadir y sustituir municipios en el mapa dinámicamente (Prioridad: P2)

Como usuario o vista consumidora, quiero poder añadir municipios o sustituir el conjunto actual de ubicaciones para actualizar el mapa sin recargar la página.

**Por qué esta prioridad**: la API pública y los eventos del navegador son la parte funcional dinámica del componente.

**Prueba independiente**: disparar `location-map:add` o `location-map:set` y verificar que el mapa añade o reemplaza marcadores.

**Escenarios de aceptación**:

1. **Dado** que se emite `location-map:add`, **cuando** el evento llega al navegador, **entonces** se añade un nuevo marcador.
2. **Dado** que se emite `location-map:set`, **cuando** el evento llega al navegador, **entonces** el conjunto anterior se limpia y se sustituyen los municipios.
3. **Dado** que no hay coordenadas para un municipio, **cuando** se intenta mostrar, **entonces** el componente intenta geocodificar el nombre con Nominatim.

### Casos límite

- ¿Qué ocurre si el servicio de geocoding no responde?
- ¿Qué ocurre si no existe un instrumento asociado al usuario autenticado?
- ¿Qué ocurre si el componente se monta en una vista sin datos de municipios?
- ¿Qué ocurre si Leaflet no está cargado en la página consumidora?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe renderizar un contenedor de mapa con altura configurable.
- **FR-002**: El sistema debe poder inicializarse con una colección de municipios desde el backend.
- **FR-003**: El sistema debe añadir marcadores para cada municipio válido.
- **FR-004**: El sistema debe geocodificar por nombre cuando un municipio no tenga coordenadas.
- **FR-005**: El sistema debe permitir sustituir el conjunto de municipios sin recargar la página.
- **FR-006**: El sistema debe permitir añadir un municipio individual mediante eventos del navegador.
- **FR-007**: El sistema debe usar un icono de marcador derivado del instrumento del usuario autenticado, con fallback al logo.
- **FR-008**: El sistema debe mantener compatibilidad con las vistas Blade que ya montan el componente.

### Superficie Laravel / Livewire

- **Livewire**: `app/Livewire/LocationMap.php` contiene el componente principal.
- **Vistas**: `resources/views/livewire/location-map.blade.php` implementa la lógica visual, Leaflet y la API pública.
- **Montajes existentes**: `resources/views/actuaciones/detalles-actuacion.blade.php`, `resources/views/components/welcome-user.blade.php` y `resources/views/livewire/contratos/contrato.blade.php` consumen el componente.

### Entidades clave

- **Municipio**: entrada geográfica mostrada como marcador.
- **Mapa**: contenedor visual interactivo con marcadores y vista centrada.
- **Usuario autenticado**: fuente del icono del marcador.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario ve el mapa en las pantallas que lo montan.
- **SC-002**: El mapa puede inicializarse con municipios preexistentes.
- **SC-003**: El mapa puede añadir un municipio nuevo sin recargar la página.
- **SC-004**: El mapa puede sustituir todos los municipios visibles mediante un evento.
- **SC-005**: La implementación sigue funcionando dentro de las vistas existentes del proyecto.

## Suposiciones

- El componente es una pieza reutilizable de visualización, no un CRUD independiente.
- Leaflet y el script de geocoding están disponibles en las páginas consumidoras.
- El comportamiento depende del usuario autenticado para determinar el icono del marcador.
- La cobertura de pruebas del módulo parece inexistente, así que esta migración documenta comportamiento observado, no validado por tests dedicados.