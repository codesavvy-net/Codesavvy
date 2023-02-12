<?php

namespace Esquadrao21\Squad21\Controllers\Pages;

use Esquadrao21\Squad21\Models\Users;
use Esquadrao21\Squad21\Utils\Pages;
use Slim\Psr7\Response;

class Home extends Pages
{
  function action(): Response
  {

    $users = new Users();

    return $this->view->render($this->response, 'home.html', [
      'name' => $users->getName()
    ]);
  }
}
