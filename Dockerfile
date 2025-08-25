FROM php:8.1-cli

# Install system dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git unzip wget \
        libicu-dev libzip-dev libonig-dev \
        libsqlite3-dev \
        nodejs npm \
    && rm -rf /var/lib/apt/lists/*

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    && mv composer.phar /usr/local/bin/composer

# Symfony CLI
RUN wget https://github.com/symfony-cli/symfony-cli/releases/latest/download/symfony-cli_linux_amd64.tar.gz \
    && tar -xzf symfony-cli_linux_amd64.tar.gz \
    && mv symfony /usr/local/bin/symfony \
    && rm symfony-cli_linux_amd64.tar.gz

# PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo pdo_sqlite \
        intl zip mbstring

# Yarn
RUN npm install --global yarn

WORKDIR /var/www/html/

# Create directories with proper permissions
RUN mkdir -p var/cache var/log \
    && chmod -R 777 var/

CMD tail -f /dev/null
