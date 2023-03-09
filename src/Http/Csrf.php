<?php

use Slim\Csrf\Guard;

// Register Middleware On Container
$container->set('csrf', function () use ($responseFactory) {
  return new Guard($responseFactory);
});

$GLOBALS['csrf'] = $container->get('csrf');

// Register Middleware To Be Executed On All Routes
$app->add('csrf');
