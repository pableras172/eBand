#!/bin/bash

echo "🚀 Iniciando despliegue de eBand..."

# Colores para mensajes
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Función para imprimir mensajes
print_message() {
    echo -e "${BLUE}▶ $1${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

# 3. Compilar assets
print_message "Compilando assets..."
npm run build || {
    print_error "Error al compilar assets"
    exit 1
}
print_success "Assets compilados"

# 4. Limpiar cachés
print_message "Limpiando cachés..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
print_success "Cachés limpiados"

# 5. Optimizar aplicación
print_message "Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
print_success "Aplicación optimizada"

echo ""
echo -e "${GREEN}🎉 ¡Despliegue completado con éxito!${NC}"
echo ""
