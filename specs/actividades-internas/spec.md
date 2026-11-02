# Especificación de la Feature: Actividades Internas

**Feature Branch**: `feature/actividades-internas`

**Creado**: 2026-11-02

**Estado**: Implemented (Pending Pint & DB migration)

**Entrada**: Nueva funcionalidad para organizar y gestionar eventos internos de la banda (cenas, comidas, excursiones u otros), permitiendo a los músicos inscribirse con acompañantes mediante opciones de menú/ticket con precios variables, registrar alergias/observaciones cuando aplique y gestionar cobros y exportaciones a nivel administrativo.

---

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Consultar actividades internas disponibles (Prioridad: P1)

Como músico de la banda, quiero consultar las actividades internas programadas (con su tipo, fecha, lugar, fecha límite de inscripción y estado) para saber en qué eventos puedo participar.

* **Por qué esta prioridad**: Es la puerta de entrada para que los miembros de la banda conozcan los eventos disponibles.
* **Prueba independiente**: Acceder a la sección de actividades internas como músico autenticado y verificar que se listan las actividades abiertas y públicas con sus datos clave e iconos identificativos.
* **Escenarios de aceptación**:
  1. **Dado** que existen actividades en estado `abierta`, **cuando** un músico accede al listado, **entonces** se visualizan ordenadas cronológicamente, con iconos representativos según el tipo (`comida`, `cena`, `excursion`, `otro`).
  2. **Dado** que una actividad está en estado `borrador`, **cuando** un músico regular consulta el listado, **entonces** no puede verla (solo visible para administradores).
  3. **Dado** que la fecha actual supera `fecha_limite_inscripcion`, **cuando** se visualiza la actividad, **entonces** se muestra un indicador de inscripciones cerradas/finalizadas.

---

### Historia de usuario 2 - Inscripción del músico en una actividad (Prioridad: P1)

Como músico de la banda, quiero seleccionar las opciones de menú/asistencia deseadas (para mí y mis acompañantes), registrar posibles alergias e intolerancias si el evento es de comida/cena y confirmar mi inscripción, conociendo el importe total exacto a abonar.

* **Por qué esta prioridad**: Es el flujo central operativo que sustituye las listas informales de WhatsApp o papel.
* **Prueba independiente**: Como músico, acceder al formulario de inscripción de una actividad abierta, seleccionar cantidades para una o más opciones, ingresar observaciones si aplica, y enviar el formulario verificando que se persiste la inscripción con el total calculado.
* **Escenarios de aceptación**:
  1. **Dado** que la actividad está abierta y dentro del plazo límite, **cuando** el músico selecciona cantidades (ej. 2 menús carne y 1 infantil), **entonces** la interfaz actualiza reactivamente el subtotal y el importe total a pagar.
  2. **Dado** que el tipo de actividad es `comida` o `cena`, **cuando** el músico se inscribe, **entonces** se muestra el campo de texto de observaciones/alergias para detallar necesidades alimentarias de los asistentes.
  3. **Dado** que el tipo de actividad es `excursion` u `otro`, **cuando** el músico se inscribe, **entonces** el campo de observaciones/alergias no se solicita o permanece oculto/deshabilitado.
  4. **Dado** que el músico confirma su inscripción, **cuando** la envía con éxito, **entonces** queda registrada como única para ese usuario y pasa a ver una pantalla de resumen con su selección, importe total, estado de pago e instrucciones de pago (Bizum/cuenta bancaria).
  5. **Dado** que un músico no desea o no puede acudir a la actividad, **cuando** pulsa en el botón "No voy", **entonces** se registra su respuesta de no asistencia (`asiste = false`, total 0.00 €), informando a la organización y permitiéndole cambiar de opinión mientras el plazo esté abierto.
  6. **Dado** que un músico ya se ha inscrito, **cuando** vuelve a acceder a la actividad, **entonces** ve el resumen de su reserva; si aún no ha pagado y el plazo sigue abierto, puede indicar que finalmente no acude ("No voy") o contactar con la administración para cambios.

---

### Historia de usuario 3 - Gestión administrativa de actividades y opciones (Prioridad: P1)

Como administrador o miembro de la junta, quiero crear, editar y gestionar actividades internas y sus opciones de pago (título, descripción, precio) para configurar los eventos de la banda.

* **Por qué esta prioridad**: Sin la administración no pueden existir actividades ni opciones configuradas.
* **Prueba independiente**: Con rol de administrador, acceder al panel de gestión, crear una nueva actividad con múltiples opciones de precio, modificar sus datos y cambiar su estado (`borrador`, `abierta`, `cerrada`).
* **Escenarios de aceptación**:
  1. **Dado** un usuario con permisos de administración, **cuando** crea una actividad con campos válidos (`titulo`, `tipo`, `fecha`, `fecha_limite_inscripcion`, `lugar`, `instrucciones_pago`), **entonces** la actividad se guarda correctamente.
  2. **Dado** una actividad, **cuando** el administrador añade o edita opciones (ej: "Menú Adulto Carne" a 25.00 €, "Menú Infantil" a 12.00 €), **entonces** las opciones quedan asociadas con sus respectivos precios y cupos ilimitados.
  3. **Dado** que el administrador cambia el estado de una actividad a `cerrada`, **cuando** cualquier músico intente inscribirse, **entonces** el sistema bloquea nuevas inscripciones.

---

### Historia de usuario 4 - Control de asistencia, menús y cobros (Prioridad: P1)

Como administrador, quiero consultar la lista de inscritos de una actividad, ver el recuento consolidado de platos/opciones seleccionadas para facilitar el encargo al restaurante/proveedor, y registrar el cobro de cada participante indicando opcionalmente el método de pago.

* **Por qué esta prioridad**: Necesidad crítica de coordinación con el restaurante/autobús y control de tesorería.
* **Prueba independiente**: Visualizar el panel de detalle de la actividad en administración, comprobar que los contadores suman fielmente las cantidades de cada opción, y marcar como "Pagado" la inscripción de un músico con un método de pago.
* **Escenarios de aceptación**:
  1. **Dado** que hay múltiples músicos inscritos, **cuando** el administrador visualiza la actividad, **entonces** ve un resumen métrico con el recuento total por opción (ej: 45 Menú Carne, 20 Menú Pescado, 10 Menú Infantil) y el balance de recaudación (Total previsto, Total cobrado, Total pendiente).
  2. **Dado** un registro de inscripción pendiente, **cuando** el administrador pulsa en marcar como "Pagado", **entonces** puede opcionalmente seleccionar el método de pago (`bizum`, `efectivo`, `transferencia`, `otro`) y el sistema guarda el estado `pagado = true` con la fecha y método.
  3. **Dado** que un músico necesita modificar sus opciones o darse de baja, **cuando** el administrador edita o elimina la inscripción desde el panel, **entonces** las cantidades y totales se recalculan automáticamente.
  4. **Dado** que un miembro sin acceso a la app o una persona externa necesita apuntarse, **cuando** el administrador pulsa en "Inscribir Asistente", **entonces** puede seleccionar un miembro existente o indicar un nombre manual, seleccionar las cantidades de cada menú/opción (ej: 2 adultos y 2 niños), indicar alergias y opcionalmente marcar el pago directo.

---

### Historia de usuario 5 - Exportación a Excel de inscritos y platos (Prioridad: P2)

Como administrador, quiero exportar a Excel el listado completo de la actividad con el detalle de asistentes, cantidades por opción, alergias y estado de pago para llevarlo al evento o entregárselo a la empresa de catering/restaurante.

* **Por qué esta prioridad**: Facilita la operativa física del evento fuera de la plataforma web.
* **Prueba independiente**: Hacer clic en el botón "Exportar a Excel" y verificar que se descarga un archivo estructurado con todos los datos correctos.
* **Escenarios de aceptación**:
  1. **Dado** una actividad con inscripciones, **cuando** el administrador ejecuta la exportación a Excel, **entonces** se genera y descarga un fichero (`.xlsx` o `.csv`) con las columnas de: Músico, Opciones y cantidades desglosadas, Total importe, Estado de pago, Método de pago y Observaciones/Alergias.

---

### Casos límite

- ¿Qué ocurre si un músico intenta inscribirse después de la `fecha_limite_inscripcion`? El sistema debe impedirlo a nivel de validación del FormRequest/Livewire, impidiendo el guardado y mostrando un mensaje de error.
- ¿Qué ocurre si un músico no selecciona ninguna opción (cantidad 0 en todas)? La validación debe exigir que al menos una opción tenga cantidad >= 1.
- ¿Qué ocurre si un administrador borra una opción que ya ha sido seleccionada por algún músico en inscripciones previas? Se debe proteger con integridad referencial o borrado lógico (`SoftDeletes`) para preservar el histórico de precios y selecciones.
- ¿Qué ocurre si cambian los precios de una opción después de que usuarios ya se hayan inscrito? Cada línea de inscripción (`ActividadInscripcionItem`) almacena el `precio_unitario` y `subtotal` histórico al momento de inscribirse.

---

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir crear, editar y consultar actividades con: `titulo`, `tipo` (`comida`, `cena`, `excursion`, `otro`), `descripcion`, `lugar`, `fecha`, `fecha_limite_inscripcion`, `estado` (`borrador`, `abierta`, `cerrada`) e `instrucciones_pago`.
- **FR-002**: El sistema debe permitir asociar múltiples opciones de asistencia/pago a una actividad con `titulo`, `descripcion` y `precio`.
- **FR-003**: El sistema debe mostrar a los músicos el listado de actividades disponibles con iconos e información clara.
- **FR-004**: El sistema debe permitir a cada músico registrar una única inscripción con una o varias opciones y sus respectivas cantidades.
- **FR-005**: El sistema debe mostrar el campo de `observaciones_alergias` de comensales únicamente cuando la actividad sea de tipo `comida` o `cena`.
- **FR-006**: El sistema debe calcular y mostrar dinámicamente el importe total de la inscripción.
- **FR-007**: El sistema debe impedir al músico modificar o cancelar su inscripción una vez enviada, mostrándole un resumen de su solicitud e instrucciones de pago.
- **FR-008**: El sistema debe permitir al administrador ver un resumen consolidado con el recuento total de cada opción y totales monetarios.
- **FR-009**: El sistema debe permitir al administrador gestionar el estado de pago de cada inscripción (`pagado = true/false`, `metodo_pago` y `fecha_pago`).
- **FR-010**: El sistema debe permitir al administrador editar o anular inscripciones a petición de los músicos.
- **FR-011**: El sistema debe permitir exportar a Excel el listado de inscritos y platos/opciones de la actividad.

---

### Superficie Laravel / Livewire

- **Rutas**:
  - `routes/web.php`: Rutas bajo middleware de autenticación `auth`.
    - `actividades` (Listado y vista músico).
    - `actividades/{actividad}` (Detalle e inscripción / confirmación).
    - `admin/actividades` (Gestión administrativa).
    - `admin/actividades/{actividad}/export` (Exportación a Excel).
- **Modelos**:
  - `App\Models\Actividad`: Relaciones `hasMany(ActividadOpcion::class)`, `hasMany(ActividadInscripcion::class)`.
  - `App\Models\ActividadOpcion`: Relación `belongsTo(Actividad::class)`.
  - `App\Models\ActividadInscripcion`: Relaciones `belongsTo(Actividad::class)`, `belongsTo(User::class)`, `hasMany(ActividadInscripcionItem::class)`.
  - `App\Models\ActividadInscripcionItem`: Relaciones `belongsTo(ActividadInscripcion::class)`, `belongsTo(ActividadOpcion::class)`.
- **Livewire Components** (Livewire 3):
  - `App\Livewire\Actividades\ActividadesIndex`: Listado de actividades para músicos.
  - `App\Livewire\Actividades\ActividadInscripcionForm`: Formulario reactivo de selección de opciones, cálculo en tiempo real y confirmación.
  - `App\Livewire\Actividades\Admin\ActividadAdminIndex`: Gestión y listado administrativo de eventos.
  - `App\Livewire\Actividades\Admin\ActividadAdminDetail`: Panel de recuento de platos/opciones, tabla de inscritos, marcado de pagos y edición administrativa.
- **Validaciones**:
  - FormRequests dedicados para creación/edición de actividades y registro de inscripciones.

---

### Entidades clave y Modelo de Datos

```
+------------------------------------+
|             Actividad              |
+------------------------------------+
| id                                 |
| titulo: string                     |
| tipo: enum(comida,cena,excursion..) |
| descripcion: text                  |
| lugar: string (nullable)           |
| fecha: datetime                    |
| fecha_limite_inscripcion: datetime |
| estado: enum(borrador,abierta..)   |
| instrucciones_pago: text (null)    |
| timestamps                         |
+------------------------------------+
                 | 1:N
                 v
+------------------------------------+       +---------------------------------------+
|          ActividadOpcion           |       |         ActividadInscripcion          |
+------------------------------------+       +---------------------------------------+
| id                                 |       | id                                    |
| actividad_id: fk                   |       | actividad_id: fk                      |
| titulo: string                     |       | user_id: fk (Unique [actividad, user])|
| descripcion: text (nullable)       |       | fecha_inscripcion: datetime           |
| precio: decimal(8,2)               |       | total: decimal(8,2)                   |
| timestamps                         |       | observaciones_alergias: text (null)   |
+------------------------------------+       | pagado: boolean                       |
                 | 1:N                       | metodo_pago: string (nullable)        |
                 v                           | fecha_pago: datetime (nullable)       |
+------------------------------------+       | timestamps                            |
|       ActividadInscripcionItem     |       +---------------------------------------+
+------------------------------------+                           | 1:N
| id                                 | <-------------------------+
| actividad_inscripcion_id: fk       |
| actividad_opcion_id: fk            |
| cantidad: int                      |
| precio_unitario: decimal(8,2)      |
| subtotal: decimal(8,2)             |
| timestamps                         |
+------------------------------------+
```

---

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un músico puede consultar una actividad abierta y completar su inscripción con múltiples cantidades por opción en menos de 1 minuto.
- **SC-002**: El cálculo del importe total en el formulario se actualiza en tiempo real de forma reactiva sin recargar la página.
- **SC-003**: Se restringe a una única inscripción por usuario y actividad.
- **SC-004**: Los administradores disponen de un recuento instantáneo y agrupado de platos/opciones solicitados para transmitir al proveedor.
- **SC-005**: El administrador puede cambiar el estado de pago de cualquier inscripción con trazabilidad del método de abono.
- **SC-006**: Se genera la exportación en Excel con todos los datos consolidados y listos para su uso operativo.
