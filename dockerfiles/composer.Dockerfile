FROM composer:2.4

WORKDIR /var/www/laravel

ENTRYPOINT [ "composer", "--ignore-platform-reqs" ]