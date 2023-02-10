<?php

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

if (true) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  $twig = Twig::create('../src/Views', ['cache' => false]);
  $app->addErrorMiddleware(true, true, true);
} else {
  $twig = Twig::create('../src/Views', ['cache' => __DIR__ . '/../cache']);
  $app->addErrorMiddleware(true, true, true);
}

$app->add(TwigMiddleware::create($app, $twig));
$app->addRoutingMiddleware();

require "../src/router.php";

$app->run();
