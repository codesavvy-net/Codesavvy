<?php

use Esquadrao21\Squad21\Utils\Env;

Env::load();

if ($_ENV['ENVIRONMENT'] !== 'production') {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  $app->addErrorMiddleware(true, true, true);
} else
  $app->addErrorMiddleware(false, true, true);

require "Twig.php";

require 'Routes.php';
