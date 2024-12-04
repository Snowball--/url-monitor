FROM phpdockerio/php:8.2-fpm

RUN apt-get update \
    # Install php extensions
    && apt-get -y --no-install-recommends install \
        php8.2-memcached \
        php8.2-mysql \
        php8.2-zmq \
        php8.2-bcmath \
        php8.2-bz2 \
        php8.2-gd \
        php8.2-imagick \
        php8.2-intl \
        php8.2-mbstring \
        php8.2-xmlrpc \
        php8.2-xdebug \
        php8.2-ds \
    # Install other staff
    && apt-get -y --no-install-recommends install curl git openssl snmp-mibs-downloader iputils-ping \
    # Clean up
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR "/app"
