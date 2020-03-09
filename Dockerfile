FROM jrareas/php-7.2-apache-composer

ARG WITH_XDEBUG
ARG PRODUCTION

RUN apt-get update && apt-get install -y \
        libpng-dev \
        libicu-dev \
        cron \
   && docker-php-ext-install zip \
   && docker-php-ext-install intl \
   && docker-php-ext-install pdo_mysql

COPY ./app /app
WORKDIR /app

RUN mkdir -p /etc/apache2/ssl/
COPY ./apache2/ssl/* /etc/apache2/ssl/
COPY ./apache2/sites-available/* /etc/apache2/sites-available/

RUN composer install
RUN a2enmod ssl
RUN a2ensite laravel
RUN a2ensite default-ssl

RUN chmod -R 777 storage/
COPY .env /app

RUN if [ $WITH_XDEBUG = "true" ] ; then \
	    pecl install xdebug; \
	    docker-php-ext-enable xdebug; \
	    echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
	    echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
	    echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
	    echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
	    echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
	    echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
	    echo "xdebug.remote_host=10.254.254.254" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
	    echo "xdebug.remote_log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
	fi ;

RUN curl -sL https://deb.nodesource.com/setup_13.x | bash -
RUN apt-get install -y nodejs
RUN npm install && npm run dev

RUN if [ $PRODUCTION = "true" ] ; then \
        composer install --optimize-autoloader --no-dev; \
        php artisan config:cache; \
        php artisan route:cache; \
        php artisan view:cache; \
    fi ;

CMD [ "sh", "-c", "cron && apache2-foreground" ]