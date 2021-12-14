FROM php:8.0-fpm AS base

ARG WWWUSER=1000
ARG WWWGROUP=1000
WORKDIR /var/www/html

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN usermod -u $WWWUSER www-data && \
    groupmod -g $WWWGROUP www-data && \
    chown www-data:www-data /var/www -R && \
    apt update && \
    apt install -y rsync && \
    install-php-extensions @composer

COPY --chown=www-data:www-data . /var/www/html

USER www-data

#------------------------------
# Build image for dev
#------------------------------
FROM base AS dev

USER root
RUN install-php-extensions xdebug
USER www-data

RUN whoami

RUN composer install

#------------------------------
# build assets for production
#------------------------------
FROM node:14 AS assets

WORKDIR /tmp/app
ADD . /tmp/app

RUN npm install && \
    npm run prod



#------------------------------
# build production image
#------------------------------
FROM base AS prod

COPY --from=assets --chown=www-data:www-data /tmp/app/public /var/www/html/dist

RUN ls -la dist/

RUN composer install --no-dev -q \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --no-dev && \
     rsync -a dist/ public/
