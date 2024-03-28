FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache supervisor

RUN touch /var/run/supervisor.sock

RUN mkdir -p "/etc/supervisor/logs"

RUN chmod 777 /etc 

# RUN touch /etc/supervisord.conf

# RUN chmod 777 /etc/supervisord.conf

WORKDIR /usr/bin