# Especificación de la Feature: Actuaciones

**Feature Branch**: `[actuaciones]`

**Creado**: 2026-07-17

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Http/Controllers/ActuacionController.php`, `app/Livewire/Actuaciones/` y `resources/views/actuaciones/`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Consultar actuaciones y su distribución pública (Prioridad: P1)

Como usuario de la banda, quiero consultar las actuaciones visibles y su distribución por fechas para saber qué actuaciones vienen próximamente y en qué contexto se agrupan.

**Por qué esta prioridad**: es la base de consulta pública y operativa del módulo; permite ver el valor del sistema sin necesidad de permisos administrativos.

**Prueba independiente**: acceder a la vista pública de actuaciones y comprobar que se muestran las actuaciones visibles, agrupadas por mes/fecha, con los datos relacionados de contrato y tipo de actuación.

**Escenarios de aceptación**:

1. **Dado** que existen actuaciones visibles en fechas futuras, **cuando** se abre la vista pública de listados, **entonces** se muestran ordenadas por fecha ascendente y agrupadas por mes.
2. **Dado** que una actuación tiene contrato y tipo de actuación relacionados, **cuando** se visualiza el listado, **entonces** se muestran los datos relacionados sin romper la vista.

---

### Historia de usuario 2 - Gestionar actuaciones desde administración (Prioridad: P1)

Como administrador, quiero crear, actualizar y marcar actuaciones como borrador para poder preparar la programación antes de publicarla.

**Por qué esta prioridad**: el flujo de gestión administrativa es el núcleo del módulo y está directamente ligado a la persistencia de datos.

**Prueba independiente**: crear y actualizar una actuación con autenticación de administrador, verificando que el campo `is_draft` se guarda correctamente y que los datos obligatorios se validan.

**Escenarios de aceptación**:

1. **Dado** que estoy autenticado con permisos de administración, **cuando** creo una actuación con datos válidos, **entonces** la actuación se guarda y queda asociada al contrato y al tipo de actuación.
2. **Dado** que una actuación se crea sin `is_draft`, **cuando** se guarda, **entonces** el valor por defecto es `false`.
3. **Dado** que una actuación se crea o edita con `is_draft = true`, **cuando** se persiste, **entonces** el valor se conserva como borrador.

---

### Historia de usuario 3 - Notificar y reutilizar información operativa de actuaciones (Prioridad: P2)

Como administrador, quiero notificar actuaciones y reutilizar información operativa como ubicaciones, calendarios y listados para coordinar la actividad de la banda.

**Por qué esta prioridad**: amplía la utilidad del módulo hacia coordinación operativa y comunicación.

**Prueba independiente**: ejecutar las rutas de notificación y de consulta operativa sobre una actuación existente y verificar que responden con éxito o con mensajes de error apropiados.

**Escenarios de aceptación**:

1. **Dado** que existe una actuación válida, **cuando** se solicita su notificación, **entonces** se envía la notificación y se devuelve un mensaje de éxito.
2. **Dado** que una actuación tiene contrato con coordenadas, **cuando** se solicita la vista de ubicaciones, **entonces** se devuelve el JSON con los puntos necesarios para el mapa.
3. **Dado** que se accede al detalle/listado de una actuación, **cuando** se renderiza la vista, **entonces** se muestran los datos operativos relevantes para la coordinación.

### Casos límite

- ¿Qué ocurre si el usuario no está autenticado o no tiene permisos de admin para crear/editar/notificar?
- ¿Qué ocurre si una actuación no existe al intentar notificarla?
- ¿Qué ocurre si el contrato asociado no tiene coordenadas o datos completos?
- ¿Qué ocurre si la generación de calendario ICS o la notificación externa falla?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir consultar actuaciones visibles y futuras en una vista pública ordenada por fecha.
- **FR-002**: El sistema debe agrupar las actuaciones por mes/fecha para facilitar la lectura operativa.
- **FR-003**: El sistema debe permitir a un administrador crear actuaciones asociadas a contratos y tipos de actuación.
- **FR-004**: El sistema debe validar los campos obligatorios antes de guardar una actuación.
- **FR-005**: El sistema debe persistir el estado `is_draft` y respetar su valor por defecto cuando no se envía.
- **FR-006**: El sistema debe permitir editar actuaciones existentes desde el área administrativa.
- **FR-007**: El sistema debe permitir notificar una actuación existente y devolver un resultado comprensible.
- **FR-008**: El sistema debe exponer datos operativos de ubicación y detalle para actuaciones relacionadas con contratos con coordenadas.
- **FR-009**: El sistema debe mantener compatibilidad con las vistas Livewire y Blade existentes del módulo.

### Superficie Laravel / Livewire

- **Rutas**: `routes/web.php` contiene `actuacion`, `actuaciones.usuario.anyo`, `actuaciones.usuario.listatipo`, `actuaciones.usuario.poblacion`, `actuaciones.usuario.estadisticas.tipo`, `actuaciones-tipo`, `actuaciones-fecha`, `actuaciones-poblacion`, `actuacion.createtocontract`, `notificaractuacion`, `notificaractuacionlista` y `ubicaciones-contratos`.
- **Controladores**: `app/Http/Controllers/ActuacionController.php` orquesta la mayor parte del comportamiento.
- **Livewire**: `app/Livewire/Actuaciones/ContratoActuaciones.php` participa en la edición/gestión de actuaciones por contrato.
- **Vistas**: `resources/views/actuaciones/`, `resources/views/livewire/contratos/actuacions.blade.php` y vistas de detalle/listado relacionadas.
- **Persistencia**: modelos `Actuacion`, `Contratos`, `Tipoactuacion`, `Listas`, `ListasUser` y relación con `User`.

### Entidades clave

- **Actuacion**: representa una actuación programada, con fecha, descripción, tipo, visibilidad, borrador y datos de coste.
- **Contratos**: representa el contrato asociado a la actuación y puede aportar población y coordenadas.
- **Tipoactuacion**: clasifica la actuación por categoría operativa.
- **Listas**: agrupa actuaciones para coordinación y notificación.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un administrador puede crear una actuación válida y verla persistida sin errores de validación.
- **SC-002**: Las actuaciones visibles se presentan agrupadas y ordenadas de forma consistente para consulta pública.
- **SC-003**: El módulo permite distinguir de forma fiable las actuaciones en borrador de las publicadas.
- **SC-004**: Las operaciones de notificación y consulta operativa devuelven un resultado comprensible para el usuario.
- **SC-005**: Las vistas existentes del módulo siguen funcionando sin romper la navegación ni las relaciones entre datos.

## Suposiciones

- Se reutiliza la autenticación y autorización existente de Laravel.
- El módulo mantiene la estructura monolítica actual y no se extrae a un servicio separado.
- La generación de ICS y las notificaciones externas se consideran parte del comportamiento existente.
- La cobertura de pruebas actual es parcial y se apoya principalmente en el comportamiento de borradores (`is_draft`).