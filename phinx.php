<?php

use Symfony\Component\Dotenv\Dotenv;

require "vendor/autoload.php";

$dotEnv = new Dotenv();

$dotEnv->load('.env');

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'log',
            'default_environment' => 'environment',
            'environment'   => [
                'adapter'   => $_ENV['DB_ADAPTER'],
                'host'      => $_ENV['DB_HOST'],
                'name'      => $_ENV['DB_NAME'],
                'user'      => $_ENV['DB_USER'],
                'pass'      => $_ENV['DB_PASS'],
                'port'      => $_ENV['DB_PORT'],
                'charset'   => $_ENV['DB_CHARSET']
            ]
        ],
        'version_order' => 'creation'
    ];
