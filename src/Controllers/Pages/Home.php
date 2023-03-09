<?php

namespace Esquadrao21\Squad21\Controllers\Pages;

use Esquadrao21\Squad21\Models\Users;
use Esquadrao21\Squad21\Utils\Pages;
use Slim\Psr7\Response;

class Home extends Pages
{

  /**
   * Retorna o conteúdo de uma view
   * @return Response
   */
  function action(): Response
  {

    //Instância de usuário
    $users = new Users();

    //Renderiza view
    return $this->view->render($this->response, 'home.html', [

      //Puxa nome do usuário para View
      'name'        => $_SESSION['name'] ?? null,
      'title'       => 'Titulo',
      'description' => 'Codesavvy é um projeto ...'
    ]);
  }
}
