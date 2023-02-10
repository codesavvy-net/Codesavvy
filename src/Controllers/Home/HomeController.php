<?php

namespace Esquadrao21\Squad21\Controllers\Home;

use Esquadrao21\Squad21\Controllers\Controller;
use Slim\Psr7\Response;

class HomeController extends Controller
{
  function action(): Response
  {
    return $this->view->render($this->response, 'home.html', [
      'name' => 'Nicola'
    ]);
  }
}
