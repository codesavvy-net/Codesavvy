<?php

namespace Esquadrao21\Squad21\Controllers\Pages;

use csrfProtector;
use Esquadrao21\Squad21\Models\Users;
use Esquadrao21\Squad21\Utils\Pages;
use Slim\Psr7\Response;

class SignIn extends Pages
{

  private Users $users;

  /**
   * Retorna o conteúdo de uma view
   * @return Response
   */
  function action(): Response
  {
    //Instância de usuário
    $this->users = new Users();

    $body = $this->request->getParsedBody();
    if (is_array($body)) $login = $this->login($body);

    if (isset($_SESSION['uuid'])) {
      header("Location: /perfil");
      exit;
    }

    return $this->view($login ?? false);
  }

  private function login(array $body): bool
  {
    return !$this->users->signIn($body['login'], $body['password']);
  }

  private function view(bool $login): Response
  {
    $csrf = $GLOBALS['csrf'];
    $nameKey = $csrf->getTokenNameKey();
    $valueKey = $csrf->getTokenValueKey();

    //Renderiza view
    return $this->view->render($this->response, 'signIn.html', [

      'token' => [
        'nameKey'   => $nameKey,
        'valueKey'  => $valueKey,
        'name'      => $this->request->getAttribute($nameKey),
        'value'     => $this->request->getAttribute($valueKey)
      ],

      'login'       => ($login ?? NULL)
    ]);
  }
}
