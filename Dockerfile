FROM jrareas/php-7.2-apache-composer
RUN apt-get update && apt-get install -y \
        libpng-dev \
        cron \
   && docker-php-ext-install zip

COPY ./app /app
WORKDIR /app

COPY ./laravel.conf /etc/apache2/sites-available/

RUN composer install
RUN a2ensite laravel
RUN a2enmod rewrite

RUN chmod -R 777 storage/


CMD [ "sh", "-c", "cron && apache2-foreground" ]