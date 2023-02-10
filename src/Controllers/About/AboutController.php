<?php

namespace Esquadrao21\Squad21\Controllers\About;

use Esquadrao21\Squad21\Controllers\Controller;
use Slim\Psr7\Response;

class AboutController extends Controller
{
  function action(): Response
  {
    return $this->view->render($this->response, 'about.html');
  }
}
