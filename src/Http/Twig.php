<?php

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

//Puxar diretório da Views
$views_dir = __DIR__ . DS . '..' . DS . 'Views';

//Verifica se a aplicação esta em produção
if ($_ENV['ENVIRONMENT'] === 'production')

  //Se positivo: Faz cache dos templates renderizados
  $twig = Twig::create($views_dir, ['cache' => __DIR__ . '/../cache']);
else

  //Se negativo: Não faz cache
  $twig = Twig::create($views_dir, ['cache' => false]);

$app->add(TwigMiddleware::create($app, $twig));
