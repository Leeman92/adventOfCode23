FROM php:8.3-apache-bookworm

ENV APACHE_RUN_USER ape
ENV APACHE_RUN_GROUP ape

WORKDIR /var/www/html

RUN a2enmod rewrite && \
    addgroup --gid 1000 ape && \
    adduser --uid 1000 ape --gid 1000

RUN apt-get update && apt-get install -y \
    curl zip unzip vim \
    && apt-get clean all

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer