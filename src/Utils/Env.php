<?php

namespace Esquadrao21\Squad21\Utils;

use Symfony\Component\Dotenv\Dotenv;

class Env
{

  /**
   * Ler arquivo .dot e adicionar variáveis de ambientes
   * @return void
   */
  static function load(): void
  {
    $file_dot_env = __DIR__ . DS . '..' . DS . '..' . DS . '.env';

    if (!file_exists($file_dot_env))
      die('Create file .env');

    $dotenv = new Dotenv();
    $file = $dotenv->overload($file_dot_env);
  }
}
