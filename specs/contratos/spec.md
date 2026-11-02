# Especificación de la Feature: Contratos

**Feature Branch**: `[contratos]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/Contratos/`, `app/Models/Contratos.php`, `routes/web.php` y `resources/views/livewire/contratos/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Consultar contratos por año y buscar por contenido (Prioridad: P1)

Como usuario autorizado, quiero listar contratos filtrados por año y texto para localizar rápidamente los acuerdos activos o relevantes.

**Por qué esta prioridad**: el listado es la puerta de entrada del módulo y concentra la consulta operativa diaria.

**Prueba independiente**: abrir el listado de contratos, cambiar de año y aplicar búsqueda por población, descripción o contacto.

**Escenarios de aceptación**:

1. **Dado** que accedo al listado de contratos, **cuando** se renderiza la vista, **entonces** se muestran los contratos activos para el año seleccionado.
2. **Dado** que escribo un término en la búsqueda, **cuando** se actualiza la lista, **entonces** solo aparecen contratos cuyo contenido coincide.
3. **Dado** que cambio el año desde el selector, **cuando** se recarga la página, **entonces** el listado conserva el filtro de búsqueda si existía.

---

### Historia de usuario 2 - Crear, editar y eliminar contratos (Prioridad: P1)

Como usuario administrador, quiero crear, editar y eliminar contratos con sus datos de contacto, fechas y ubicación para mantener actualizada la base operativa de actuaciones.

**Por qué esta prioridad**: la gestión CRUD es el núcleo del módulo y define la información que luego consumen las actuaciones.

**Prueba independiente**: crear un contrato válido, editarlo y eliminarlo desde el formulario, comprobando que las validaciones y mensajes funcionan.

**Escenarios de aceptación**:

1. **Dado** que abro el formulario de creación, **cuando** introduzco datos válidos, **entonces** el contrato se guarda correctamente.
2. **Dado** que edito un contrato existente, **cuando** guardo cambios válidos, **entonces** el contrato se actualiza.
3. **Dado** que elimino un contrato desde el formulario, **cuando** confirmo la acción, **entonces** el contrato desaparece y se muestra un mensaje de éxito o error apropiado.

---

### Historia de usuario 3 - Gestionar actuaciones asociadas y duplicar contratos (Prioridad: P2)

Como usuario administrador, quiero ver las actuaciones asociadas a un contrato y duplicar contratos para reutilizar información estructural sin rehacerla desde cero.

**Por qué esta prioridad**: completa el ciclo operativo del contrato y reduce trabajo manual al preparar nuevos registros similares.

**Prueba independiente**: abrir el detalle de un contrato, revisar sus actuaciones asociadas y ejecutar la duplicación.

**Escenarios de aceptación**:

1. **Dado** que abro un contrato existente, **cuando** se renderiza la vista de actuaciones, **entonces** veo las actuaciones vinculadas con su estado de borrador, si aplica.
2. **Dado** que accedo a la ruta de duplicado, **cuando** la operación se ejecuta, **entonces** se crea un nuevo contrato basado en el existente.
3. **Dado** que elimino un contrato con actuaciones relacionadas, **cuando** confirmo la acción, **entonces** se ejecuta la eliminación siguiendo el comportamiento existente del módulo.

### Casos límite

- ¿Qué ocurre si el usuario no tiene permisos de administrador para crear, editar o eliminar contratos?
- ¿Qué ocurre si se intenta duplicar un contrato inexistente?
- ¿Qué ocurre si el año seleccionado no contiene contratos?
- ¿Qué ocurre si faltan datos de localización o contacto en el formulario?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir consultar contratos con paginación y filtros por año y búsqueda textual.
- **FR-002**: El sistema debe permitir crear contratos con población, fechas, descripción y datos de contacto.
- **FR-003**: El sistema debe validar los campos obligatorios y el orden temporal de las fechas antes de guardar.
- **FR-004**: El sistema debe permitir editar contratos existentes.
- **FR-005**: El sistema debe permitir eliminar contratos autorizados desde el formulario.
- **FR-006**: El sistema debe permitir duplicar un contrato existente.
- **FR-007**: El sistema debe permitir consultar las actuaciones asociadas a un contrato.
- **FR-008**: El sistema debe mantener compatibilidad con las vistas Livewire y Blade existentes del módulo.

### Superficie Laravel / Livewire

- **Rutas**: `routes/web.php` contiene el recurso `contratos`, `contratos.anyo`, `contratos.duplicate` y `contratos.actuaciones.index`.
- **Livewire**: `app/Livewire/Contratos/ListadoContratos.php` controla el comportamiento principal.
- **Vistas**: `resources/views/livewire/contratos/index.blade.php`, `contrato.blade.php`, `create.blade.php` y `actuacions.blade.php` forman la interfaz visible.
- **Modelo**: `Contratos` centraliza el contrato y su relación con actuaciones.
- **Controlador**: `ContratosController` y las rutas asociadas participan en el duplicado y en la gestión del recurso.

### Entidades clave

- **Contratos**: representa un acuerdo operativo con fechas, contacto y ubicación.
- **Actuacion**: representa las actuaciones ligadas a un contrato.
- **Location/coordinates**: soporte operativo para ubicar contratos desde el formulario.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario autorizado puede abrir el listado de contratos y navegarlo por año y búsqueda.
- **SC-002**: Un administrador puede crear un contrato válido y verlo persistido sin errores de validación.
- **SC-003**: Un administrador puede editar y eliminar contratos con mensajes de resultado comprensibles.
- **SC-004**: Un usuario autorizado puede ver las actuaciones asociadas a un contrato.
- **SC-005**: Un administrador puede duplicar un contrato y reutilizar su información estructural.
- **SC-006**: Las vistas existentes del módulo siguen funcionando sin romper la navegación ni las relaciones entre datos.

## Suposiciones

- Se reutiliza la autenticación y autorización existente de Laravel.
- El módulo mantiene la estructura monolítica actual y no se extrae a un servicio separado.
- El comportamiento de duplicado se conserva como está implementado en la aplicación.
- La cobertura de pruebas del módulo parece inexistente, así que esta migración documenta comportamiento observado, no validado por tests dedicados.