#!/bin/bash

set -eu

cd /var/www/html

composer install

exec docker-php-entrypoint $@