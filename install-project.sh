#!/bin/bash

HC='\033[0;32m' # Heading Color
WC='\033[0;33m' # Warning Color
NC='\033[0m' # No Color

# install composer
echo -e "${HC}::::::::::::::::::::::::::Composer Install::::::::::::::::::::::::::${NC}"
composer install
echo -e "${HC}::::::::::::::::::::::::::Done Composer Install::::::::::::::::::::::::::${NC}"

# install node
echo -e "${HC}::::::::::::::::::::::::::Node packges Install::::::::::::::::::::::::::${NC}"
npm install && npm run build
echo -e "${HC}::::::::::::::::::::::::::Done node packges Install::::::::::::::::::::::::::${NC}"

# Copy .env.example to .env
echo -e "${HC}::::::::::::::::::::::::::Copy .env::::::::::::::::::::::::::${NC}"
cp .env.example .env
echo -e "${HC}::::::::::::::::::::::::::Done copy .env::::::::::::::::::::::::::${NC}"

# Key generation
echo -e "${HC}::::::::::::::::::::::::::Key generate::::::::::::::::::::::::::${NC}"
php artisan key:generate
echo -e "${HC}::::::::::::::::::::::::::Done key generate::::::::::::::::::::::::::${NC}"

# Storage Directory
echo -e "${HC}::::::::::::::::::::::::::Creating Storage Directory::::::::::::::::::::::::::${NC}"
php artisan storage:link
echo -e "${HC}::::::::::::::::::::::::::Done creating Storage Directory::::::::::::::::::::::::::${NC}"

echo -e "${HC}::::::::::::::::::::::::::Database Setup::::::::::::::::::::::::::${NC}"
read -p "PLEASE FIRST UPLOADE YOUR .env FILE TO SERVER AND THEN PRESS y : " answer
case ${answer:0:1} in
    y|Y )
        echo -e "${HC}::::::::::::::::::::::::::Database Migration::::::::::::::::::::::::::${NC}"
        php artisan migrate

        echo -e "${HC}::::::::::::::::::::::::::Seed Database::::::::::::::::::::::::::${NC}"
        php artisan db:seed

        echo -e "${HC}::::::::::::::::::::::::::Done database migration and seed::::::::::::::::::::::::::${NC}"
    ;;
    * )
        echo  -e "${WC}>PLEASE REMEMBER TO UPLOAD .env FILE ON SERVER THEN MIGRATE & SEED THE DATABASE LATER${NC}"
    ;;
esac

echo -e "${HC}::::::::::::::::::::::::::Serve the application::::::::::::::::::::::::::${NC}"
php artisan serve
