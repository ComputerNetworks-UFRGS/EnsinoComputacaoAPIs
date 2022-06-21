# --- composer build ---
FROM composer:2.0 as composer
WORKDIR /app
COPY ./ /app
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs

# --- app build
FROM php:7.2-apache

# update apt and install base packages
RUN apt-get update -qq \
    && apt-get upgrade -qq -y \
    && apt-get install -qq -y libxml2-dev  \
    && apt-get install -qq -y libzip-dev \
    # && apt-get install -qq -y supervisor \
    # && apt-get install -qq -y cron \
    && apt-get install -qq -y libjpeg62-turbo-dev libfreetype6-dev \
    && apt-get install -qq -y libpng-dev

# cleanup apt files
RUN apt-get clean -qq -y \
    && apt-get autoremove -qq -y \
    && rm -rf /var/lib/apt/lists/*

# install php modules required by laravel
RUN docker-php-ext-install dom > /dev/null \
    && docker-php-ext-install mbstring > /dev/null \
    && docker-php-ext-install pdo_mysql > /dev/null \
    && docker-php-ext-install zip > /dev/null \
    && docker-php-ext-install exif > /dev/null \
    && docker-php-ext-install pcntl > /dev/null \
    && docker-php-ext-install sockets > /dev/null \
    && docker-php-ext-install json > /dev/null  \
    && docker-php-ext-install ctype > /dev/null \
    && docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/ \
    && docker-php-ext-install gd

WORKDIR /app

### Apache config
ENV APACHE_DOCUMENT_ROOT /app/public
RUN printf '<VirtualHost *:80>\n \
    DocumentRoot /app/public\n \
    ErrorLog ${APACHE_LOG_DIR}/error.log\n \
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n \
    <Directory /app/public/>\n \
    Options Indexes FollowSymLinks MultiViews\n \
    AllowOverride All\n \
    Order allow,deny\n \
    allow from all\n \
    </Directory>\n \
    </VirtualHost>' > /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# copy app files
COPY ./ /app
COPY ./.env /app/.env

# permissões em storage e bootstrap/cache
RUN chown -R $USER:www-data storage

# import composer artifacts
COPY --from=composer /app/vendor /app/vendor
COPY --from=composer /app/public /app/public

# config apache
RUN a2enmod rewrite
RUN service apache2 restart

EXPOSE 80
