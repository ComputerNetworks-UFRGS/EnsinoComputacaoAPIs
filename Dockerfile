FROM tiagonofaro/laravel:v0

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

# RUN usermod -aG sudo www-data
# RUN su - www-data
RUN composer install

# permissões em storage e bootstrap/cache
RUN chown -R $USER:www-data storage

# config apache
RUN a2enmod rewrite
RUN service apache2 restart

EXPOSE 80
