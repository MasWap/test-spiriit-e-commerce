#!/bin/bash

# Démarrer PHP-FPM en arrière-plan
php-fpm -D

# Installer les dépendances si nécessaire
if [ ! -d "vendor" ]; then
    composer install
fi

if [ ! -d "node_modules" ]; then
    npm install
fi

# Créer la base de données si elle n'existe pas
if [ ! -f "var/data.db" ]; then
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate --no-interaction
    php bin/console doctrine:fixtures:load --no-interaction
fi

# Compiler les assets
npm run build

# Nettoyer le cache
php bin/console cache:clear

# Démarrer Nginx
nginx -g "daemon off;"
