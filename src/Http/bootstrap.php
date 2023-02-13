<?php

use Esquadrao21\Squad21\Utils\Env;
use DI\Container;
use Slim\Factory\AppFactory;

session_start();

//Carrega Variáveis de ambiente do arquivo .env
Env::load();

$container = new Container();
AppFactory::setContainer($container);

// Create App
$app = AppFactory::create();

$responseFactory = $app->getResponseFactory();

//Verifica se a aplicação esta em produção
if ($_ENV['ENVIRONMENT'] !== 'production') {

  //Se negativo: Exibe erros
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  $app->addErrorMiddleware(true, true, true);
} else

  //Se positivo: Inibe erros na tela
  $app->addErrorMiddleware(false, true, true);

//Adicionar o Twig para renderizar os templates
require "Twig.php";

//Adiciona as Rotas
require 'Routes.php';

//Adiciona CSRF
require 'Csrf.php';

$app->run();
