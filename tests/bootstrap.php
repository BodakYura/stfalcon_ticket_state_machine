<?php

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

$env = 'test';

passthru(
    sprintf(
        'php bin/console doctrine:database:drop --if-exists --force --env=%s',
        $env
    )
);

passthru(
    sprintf(
        'php bin/console doctrine:database:create --env=%s',
        $env
    )
);

passthru(
    sprintf(
        'php bin/console doctrine:schema:drop --force --env=%s',
        $env
    )
);

passthru(
    sprintf(
        'php bin/console doctrine:schema:create --env=%s',
        $env
    )
);
