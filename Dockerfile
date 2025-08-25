FROM php:8.1-cli

# Install system dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        locales apt-utils git g++ unzip wget \
        libicu-dev libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev \
        libpq-dev libsqlite3-dev \
        nodejs npm \
        apt-transport-https lsb-release ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Locales
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
    && locale-gen

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    && mv composer.phar /usr/local/bin/composer

# Symfony CLI (binaire stable depuis GitHub)
RUN wget https://github.com/symfony-cli/symfony-cli/releases/latest/download/symfony-cli_linux_amd64.tar.gz \
    && tar -xzf symfony-cli_linux_amd64.tar.gz \
    && mv symfony /usr/local/bin/symfony \
    && rm symfony-cli_linux_amd64.tar.gz

# PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo pdo_mysql pdo_pgsql pdo_sqlite \
        opcache intl zip calendar dom mbstring gd xsl

# APCu
RUN pecl install apcu && docker-php-ext-enable apcu

# Yarn
RUN npm install --global yarn

# Git identity (facultatif)
RUN git config --global user.email "lilian.layrac@gmail.com" \
    && git config --global user.name "MasWap"

WORKDIR /var/www/html/

# Créer les répertoires avec les bonnes permissions
RUN mkdir -p var/cache var/log var/sessions \
    && chmod -R 777 var/

CMD tail -f /dev/null
