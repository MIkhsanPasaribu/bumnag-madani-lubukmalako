#!/bin/bash
# ===================================================================
# DEPLOYMENT SCRIPT - BUMNag Madani Lubuk Malako
# Jalankan di Terminal cPanel: bump2384@embaloh
# ===================================================================

set -e  # Exit on error

echo "🚀 Starting Deployment..."
echo "================================================"
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# ===================================================================
# STEP 1: Clone Repository
# ===================================================================
echo -e "${YELLOW}[1/8] Cloning repository from GitHub...${NC}"
cd ~/public_html

if [ -d "bumnag-madani-lubukmalako" ]; then
    echo -e "${RED}Directory bumnag-madani-lubukmalako already exists!${NC}"
    read -p "Delete and re-clone? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        rm -rf bumnag-madani-lubukmalako
        git clone https://github.com/MIkhsanPasaribu/bumnag-madani-lubukmalako.git
    else
        cd bumnag-madani-lubukmalako
        git pull origin main
    fi
else
    git clone https://github.com/MIkhsanPasaribu/bumnag-madani-lubukmalako.git
fi

cd ~/public_html/bumnag-madani-lubukmalako
echo -e "${GREEN}✓ Repository ready${NC}"
echo ""

# ===================================================================
# STEP 2: Setup Environment File
# ===================================================================
echo -e "${YELLOW}[2/8] Setting up environment file...${NC}"

if [ ! -f .env ]; then
    cp .env.example .env
    echo -e "${GREEN}✓ .env file created${NC}"
    echo -e "${RED}⚠️  IMPORTANT: Edit .env file dengan database credentials!${NC}"
    echo ""
    echo "Buka file .env dan edit:"
    echo "  - APP_URL=https://bumnagmadani.com"
    echo "  - DB_DATABASE=bump2384_bumnag_madani"
    echo "  - DB_USERNAME=bump2384_admin"
    echo "  - DB_PASSWORD=your_database_password"
    echo ""
    read -p "Press Enter after you edit .env file..."
else
    echo -e "${GREEN}✓ .env file already exists${NC}"
fi
echo ""

# ===================================================================
# STEP 3: Install Composer Dependencies
# ===================================================================
echo -e "${YELLOW}[3/8] Installing Composer dependencies...${NC}"

# Try to find composer
if command -v composer &> /dev/null; then
    COMPOSER_CMD="composer"
elif command -v /usr/local/bin/composer &> /dev/null; then
    COMPOSER_CMD="/usr/local/bin/composer"
elif command -v /opt/cpanel/composer/bin/composer &> /dev/null; then
    COMPOSER_CMD="/opt/cpanel/composer/bin/composer"
elif [ -f "$HOME/bin/composer" ]; then
    COMPOSER_CMD="$HOME/bin/composer"
elif [ -f "$HOME/composer.phar" ]; then
    COMPOSER_CMD="php $HOME/composer.phar"
elif [ -f "composer.phar" ]; then
    COMPOSER_CMD="php composer.phar"
else
    echo -e "${RED}✗ Composer not found!${NC}"
    echo -e "${YELLOW}Trying to download composer...${NC}"
    curl -sS https://getcomposer.org/installer | php
    COMPOSER_CMD="php composer.phar"
fi

echo "Using Composer: $COMPOSER_CMD"
$COMPOSER_CMD install --optimize-autoloader --no-dev --no-interaction
echo -e "${GREEN}✓ Composer dependencies installed${NC}"
echo ""

# ===================================================================
# STEP 4: Install NPM Dependencies
# ===================================================================
echo -e "${YELLOW}[4/8] Installing NPM dependencies...${NC}"

# Try to find npm
if command -v npm &> /dev/null; then
    NPM_CMD="npm"
elif command -v /usr/local/bin/npm &> /dev/null; then
    NPM_CMD="/usr/local/bin/npm"
elif command -v /opt/cpanel/ea-nodejs16/bin/npm &> /dev/null; then
    NPM_CMD="/opt/cpanel/ea-nodejs16/bin/npm"
else
    echo -e "${RED}✗ NPM not found!${NC}"
    echo "Please contact your hosting provider to install Node.js and NPM"
    exit 1
fi

echo "Using NPM: $NPM_CMD"
$NPM_CMD install --silent
echo -e "${GREEN}✓ NPM dependencies installed${NC}"
echo ""

# ===================================================================
# STEP 5: Build Production Assets
# ===================================================================
echo -e "${YELLOW}[5/8] Building production assets...${NC}"
$NPM_CMD run build
echo -e "${GREEN}✓ Assets built successfully${NC}"
echo ""

# ===================================================================
# STEP 6: Set Permissions
# ===================================================================
echo -e "${YELLOW}[6/8] Setting file permissions...${NC}"
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/framework storage/logs
mkdir -p public/uploads
chmod -R 775 public/uploads
echo -e "${GREEN}✓ Permissions set${NC}"
echo ""

# ===================================================================
# STEP 7: Setup Database
# ===================================================================
echo -e "${YELLOW}[7/8] Setting up database...${NC}"

# Generate app key if needed
if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=\"\"" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database
read -p "Seed database with sample data? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan db:seed --force
    echo -e "${GREEN}✓ Database seeded${NC}"
fi

# Create storage link
php artisan storage:link
echo -e "${GREEN}✓ Database setup complete${NC}"
echo ""

# ===================================================================
# STEP 8: Optimize Application
# ===================================================================
echo -e "${YELLOW}[8/8] Optimizing application...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✓ Application optimized${NC}"
echo ""

# ===================================================================
# DONE!
# ===================================================================
echo ""
echo -e "${GREEN}================================================"
echo "🎉 DEPLOYMENT SUCCESSFUL!"
echo "================================================${NC}"
echo ""
echo "Next steps:"
echo "1. Set Document Root via cPanel Domains to:"
echo "   public_html/bumnag-madani-lubukmalako/public"
echo ""
echo "2. Visit your website:"
echo "   https://bumnagmadani.com"
echo ""
echo "3. Login to admin panel:"
echo "   https://bumnagmadani.com/login"
echo "   Email: admin@bumnagmadani.id"
echo "   Password: admin123"
echo ""
echo "⚠️  Remember to change admin password after first login!"
echo ""
