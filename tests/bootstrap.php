<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}

// @see preparing for functional tests

if (isset($_ENV['TEST_FUNCTIONAL']) && $_ENV['TEST_FUNCTIONAL']) {
    passthru('cd /var/www/html');

    passthru('php bin/console doctrine:database:drop --force --env=test');

    passthru('php bin/console doctrine:database:create --no-interaction --env=test');

    passthru('php bin/console doctrine:schema:create --env=test');

    passthru('php bin/console doctrine:fixtures:load --no-interaction --env=test');
}
