# Especificación de la Feature: Instrumentos

**Feature Branch**: `[instrument]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/Instrument/InstrumentClass.php`, `app/Models/Instrument.php`, `routes/web.php` y `resources/views/instrument/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Gestionar instrumentos de la banda (Prioridad: P1)

Como administrador, quiero listar, crear, editar y borrar instrumentos con su icono y orden para mantener actualizada la estructura musical de la banda.

**Por qué esta prioridad**: es el flujo principal del módulo y afecta a la organización base del resto de la aplicación.

**Prueba independiente**: abrir el listado de instrumentos, crear uno nuevo con icono, editarlo y eliminarlo.

**Escenarios de aceptación**:

1. **Dado** que abro el listado, **cuando** se renderiza la vista, **entonces** veo los instrumentos ordenados por `orden`.
2. **Dado** que creo un instrumento con nombre, icono y orden válidos, **cuando** envío el formulario, **entonces** el instrumento queda guardado.
3. **Dado** que edito un instrumento existente, **cuando** guardo los cambios, **entonces** se actualizan el nombre, el orden y, si procede, el icono.

---

### Historia de usuario 2 - Reordenar instrumentos y consultar su relación con usuarios (Prioridad: P2)

Como administrador, quiero reordenar los instrumentos y saber cuántos músicos están asociados a cada uno para mantener una vista coherente y operativa.

**Por qué esta prioridad**: el orden visual y la relación con usuarios forman parte de la gestión diaria del catálogo.

**Prueba independiente**: enviar un cambio de orden y verificar que persiste; después consultar la relación de usuarios del instrumento.

**Escenarios de aceptación**:

1. **Dado** que envío una lista de órdenes, **cuando** se procesa `updateOrder`, **entonces** el orden de los instrumentos se actualiza.
2. **Dado** que consulto la ficha de un instrumento, **cuando** se muestra su vista, **entonces** puedo ver su información y su icono actual.
3. **Dado** que un usuario tiene un instrumento asignado, **cuando** consulto el modelo, **entonces** el instrumento expone su relación `hasMany` con usuarios.

### Casos límite

- ¿Qué ocurre si subo un archivo que no es una imagen válida?
- ¿Qué ocurre si intento crear un instrumento con nombre u orden ya existentes?
- ¿Qué ocurre si no se envía un icono en la edición?
- ¿Qué ocurre si el usuario no tiene permisos de administración?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir listar instrumentos ordenados por el campo `orden`.
- **FR-002**: El sistema debe permitir crear instrumentos con nombre, icono y orden.
- **FR-003**: El sistema debe permitir editar instrumentos existentes.
- **FR-004**: El sistema debe permitir eliminar instrumentos.
- **FR-005**: El sistema debe permitir reordenar instrumentos mediante un endpoint específico.
- **FR-006**: El sistema debe almacenar los iconos en `storage/imagenes/instruments`.
- **FR-007**: El sistema debe exponer la relación entre instrumentos y usuarios.
- **FR-008**: El sistema debe mantener compatibilidad con las vistas Blade existentes del módulo.

### Superficie Laravel / Livewire

- **Livewire / controlador híbrido**: `app/Livewire/Instrument/InstrumentClass.php` contiene la lógica principal.
- **Modelo**: `app/Models/Instrument.php` define la relación con usuarios.
- **Vistas**: `resources/views/instrument/index.blade.php`, `create.blade.php` y `show.blade.php` forman la interfaz visible.
- **Rutas**: `routes/web.php` registra el recurso `instrument` y la ruta `instrument.updateOrder`.

### Entidades clave

- **Instrumento**: elemento de catálogo con nombre, icono y orden.
- **Usuario**: músico asociado a un instrumento.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un administrador puede ver el listado ordenado de instrumentos.
- **SC-002**: Un administrador puede crear un instrumento con icono válido.
- **SC-003**: Un administrador puede editar un instrumento y conservar su icono si no lo cambia.
- **SC-004**: Un administrador puede reordenar instrumentos sin salir del flujo administrativo.
- **SC-005**: La relación instrumento-usuario sigue disponible para el resto de la aplicación.

## Suposiciones

- El módulo se usa dentro de la zona administrativa protegida por permisos.
- La clase `InstrumentClass` actúa como híbrido entre controlador y superficie Livewire, aunque el comportamiento real es el de un recurso web.
- La cobertura de pruebas del módulo parece inexistente, así que esta migración documenta comportamiento observado, no validado por tests dedicados.