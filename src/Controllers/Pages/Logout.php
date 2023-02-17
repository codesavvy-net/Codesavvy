<?php

namespace Esquadrao21\Squad21\Controllers\Pages;

use Esquadrao21\Squad21\Models\Enums\UserType;
use Esquadrao21\Squad21\Models\Users;
use Esquadrao21\Squad21\Utils\Pages;
use Exception;
use Slim\Psr7\Response;

class Logout extends Pages
{
  /**
   * Retorna o conteúdo de uma view
   * @return Response
   */
  function action(): Response
  {
    session_destroy();

    return $this->response->withHeader('Location', '/')->withStatus(302);
  }
}
