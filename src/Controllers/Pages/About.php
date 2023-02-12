<?php

namespace Esquadrao21\Squad21\Controllers\Pages;

use Esquadrao21\Squad21\Utils\Env;
use Esquadrao21\Squad21\Utils\Pages;
use Slim\Psr7\Response;

class About extends Pages
{
  /**
   * Retorna o conteúdo de uma view
   * @return Response
   */
  function action(): Response
  {

    //Renderiza
    return $this->view->render($this->response, 'about.html');
  }
}
