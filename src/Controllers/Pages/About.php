<?php

namespace Esquadrao21\Squad21\Controllers\Pages;

use Esquadrao21\Squad21\Utils\Env;
use Esquadrao21\Squad21\Utils\Pages;
use Slim\Psr7\Response;

class About extends Pages
{
  function action(): Response
  {
    return $this->view->render($this->response, 'about.html');
  }
}
