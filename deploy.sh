#!/bin/bash

echo "=================================="
echo "BUMNag Madani - Deployment Script"
echo "=================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${RED}Error: File .env tidak ditemukan!${NC}"
    echo "Silakan copy .env.example ke .env dan isi konfigurasi database."
    echo "Gunakan: cp .env.example .env"
    exit 1
fi

echo -e "${YELLOW}1. Installing Composer Dependencies...${NC}"
composer install --optimize-autoloader --no-dev

echo ""
echo -e "${YELLOW}2. Installing NPM Dependencies...${NC}"
npm install

echo ""
echo -e "${YELLOW}3. Building Production Assets...${NC}"
npm run build

echo ""
echo -e "${YELLOW}4. Setting Permissions...${NC}"
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/framework storage/logs
chmod -R 775 public/uploads

echo ""
echo -e "${YELLOW}5. Generating Application Key...${NC}"
php artisan key:generate --force

echo ""
echo -e "${YELLOW}6. Running Migrations...${NC}"
php artisan migrate --force

echo ""
echo -e "${YELLOW}7. Seeding Database...${NC}"
read -p "Apakah Anda ingin seed database dengan data sample? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan db:seed --force
fi

echo ""
echo -e "${YELLOW}8. Creating Storage Link...${NC}"
php artisan storage:link

echo ""
echo -e "${YELLOW}9. Optimizing Application...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo -e "${GREEN}=================================="
echo "Deployment Berhasil!"
echo "==================================${NC}"
echo ""
echo "Langkah selanjutnya:"
echo "1. Pastikan document root mengarah ke folder 'public'"
echo "2. Akses website Anda di browser"
echo "3. Login admin: admin@bumnagmadani.id / admin123"
echo ""
