 # 🎵 eBand - Sistema de Gestión para Bandas de Música

Plataforma web completa desarrollada en **Laravel 11** para la gestión integral de bandas de música, incluyendo actuaciones, contratos, pagos, repertorio y miembros.

## ✨ Características principales

### 🎭 Gestión de Actuaciones
- Calendario interactivo de actuaciones
- Filtrado por fecha (hasta 3 meses atrás)
- Marcado de actos oficiales con indicadores visuales
- Control de visibilidad de actuaciones
- Edición rápida desde el calendario (admin)

### 👥 Gestión de Usuarios
- Autenticación segura con **Laravel Fortify**
- Verificación de email personalizada
- Restablecimiento de contraseña personalizado
- Sistema de roles y permisos

### 💰 Sistema de Pagos
- Gestión de pagos por actuación
- Control de aplicación de porcentajes
- Excepciones de pago configurables
- Tracking detallado de transacciones

### 📱 Progressive Web App (PWA)
- Instalable en Windows, Android y iOS
- `manifest.json` dinámico generado por `ManifestService`
- Funcionalidad offline
- Optimizada para dispositivos móviles

### 🎨 Interfaz Moderna
- Diseño responsive con **Tailwind CSS**
- Componentes interactivos con **Livewire**
- Páginas de error personalizadas (403, 404, 500, 503)
- Animaciones y efectos visuales
- Tema musical coherente

## 📋 Requisitos del sistema

- **PHP** 8.1 o superior
- **Composer** 2.x
- **Node.js** 16.x o superior
- **npm** o **yarn**
- **MySQL** 8.0 o **PostgreSQL** 13+
- **Extensiones PHP**: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## 🚀 Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/pableras172/eband.git
cd eband
```

### 2. Instalar dependencias
```bash
# Dependencias PHP
composer install

# Dependencias JavaScript
npm install
```

### 3. Configurar entorno
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

Edita el archivo `.env` y configura:
- Conexión a base de datos
- Configuración de correo
- URL de la aplicación
- Otras variables específicas

### 4. Preparar base de datos
```bash
# Ejecutar migraciones
php artisan migrate

# (Opcional) Poblar con datos de prueba
php artisan db:seed
```

### 5. Configurar storage
```bash
# Crear enlace simbólico
php artisan storage:link

# Establecer permisos
chmod -R 775 storage bootstrap/cache
```

### 6. Compilar assets
```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 7. Iniciar servidor de desarrollo
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## 🔧 Configuración adicional

### PWA
Asegúrate de que los iconos de la PWA estén en `public/icons/` con los siguientes tamaños:
- 72x72
- 96x96
- 128x128
- 144x144
- 152x152
- 192x192
- 384x384
- 512x512

### Correos personalizados
Las plantillas de correo se encuentran en:
- `app/Mail/VerifyEmail.php` - Verificación de email
- `app/Mail/ResetPassword.php` - Restablecimiento de contraseña
- `resources/views/mail/` - Vistas de correo

## 📦 Despliegue en producción

### 1. Activar modo mantenimiento
```bash
php artisan down
```

### 2. Actualizar código
```bash
git pull origin main
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 3. Ejecutar migraciones
```bash
php artisan migrate --force
```

### 4. Limpiar y optimizar cachés
```bash
# Limpiar cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimizar autoloader
composer dump-autoload --optimize
```

### 5. Configurar permisos
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. Reiniciar servicios (opcional)
```bash
# Si usas queues
php artisan queue:restart

# Si usas PHP-FPM
sudo systemctl restart php8.2-fpm
```

### 7. Desactivar modo mantenimiento
```bash
php artisan up
```

## 🗂️ Estructura del proyecto

```
eband/
├── app/
│   ├── Http/Controllers/    # Controladores
│   ├── Livewire/            # Componentes Livewire
│   ├── Models/              # Modelos Eloquent
│   ├── Services/            # Lógica de negocio
│   └── Policies/            # Políticas de autorización
├── database/
│   ├── migrations/          # Migraciones de BD
│   └── seeders/            # Seeders
├── resources/
│   ├── views/              # Vistas Blade
│   ├── js/                 # JavaScript/Vue
│   └── css/                # Estilos
├── routes/
│   ├── web.php             # Rutas web
│   └── api.php             # Rutas API
└── public/                 # Assets públicos
```

## 🛠️ Tecnologías utilizadas

- **Backend**: Laravel 11
- **Frontend**: Livewire, Tailwind CSS, Vite
- **Base de datos**: MySQL
- **Autenticación**: Laravel Fortify
- **Otros**: Carbon, DomPDF, Maatwebsite Excel

## 📝 Características recientes

### v2.1.0 (Febrero 2026)
- ✅ Campo `visible` para ocultar actuaciones del calendario
- ✅ Campo `oficial` para marcar actos oficiales
- ✅ Filtro de fecha para consultar actuaciones pasadas (3 meses)
- ✅ Indicadores visuales para actos oficiales (borde naranja + badge)
- ✅ Botón de edición rápida para administradores
- ✅ Páginas de error rediseñadas (403, 404, 500, 503)
- ✅ Mejoras en la interfaz de usuario

## 🤝 Contribución

Este proyecto es de uso interno. Para sugerencias o reportes de errores, contacta con el desarrollador.

## 📄 Licencia

Este proyecto es de propiedad exclusiva del desarrollador. No está permitido modificarlo ni distribuirlo sin autorización expresa.

## 👨‍💻 Desarrollador

**Pablo Eras** ([@pableras172](https://github.com/pableras172))

---

*Última actualización: Febrero 2026*


