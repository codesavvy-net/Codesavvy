<?php

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$views_dir = __DIR__ . DS . '..' . DS . 'Views';

if ($_ENV['ENVIRONMENT'] === 'production')
  $twig = Twig::create($views_dir, ['cache' => __DIR__ . '/../cache']);
else
  $twig = Twig::create($views_dir, ['cache' => false]);

$app->add(TwigMiddleware::create($app, $twig));
