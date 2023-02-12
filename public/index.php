<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

require __DIR__ . DS . '..' . DS . 'src' . DS . 'Http' . DS . 'bootstrap.php';

$app->run();
