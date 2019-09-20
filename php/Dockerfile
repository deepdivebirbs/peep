FROM composer:1.7 as vendor

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

FROM webdevops/php-apache-dev

COPY --from=vendor /app/vendor/ /var/www/vendor/

RUN mkdir /etc/apache2/peep
RUN touch /etc/apache2/peep/peep.ini && php /etc/apache2/peep/peep.ini

WORKDIR /var/www

EXPOSE 80