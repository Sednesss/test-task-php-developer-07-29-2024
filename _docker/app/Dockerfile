FROM php:8.2-fpm

ARG UID
ARG USER
ARG APP_MOUNTING_AREA
ENV UID=${UID:-1000} \ 
    USER=${USER:-sammy} \
    APP_MOUNTING_AREA=${APP_MOUNTING_AREA:-/var/www/mews-integration/app}

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libonig-dev \
    zip \
    unzip \
    libpq-dev \
    bash \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mbstring pcntl bcmath pgsql pdo_pgsql

RUN pecl install redis && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR ${APP_MOUNTING_AREA}

RUN chown -R www-data:www-data ${APP_MOUNTING_AREA}

RUN useradd -G www-data,root -u ${UID} -d /home/${USER} ${USER}
RUN mkdir -p /home/${USER}/.composer && \
    chown -R ${UID}:${UID} /home/${USER}
USER ${USER}