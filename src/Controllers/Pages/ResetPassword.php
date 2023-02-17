<?php

namespace Esquadrao21\Squad21\Controllers\Pages;

use Esquadrao21\Squad21\Models\Enums\UserType;
use Esquadrao21\Squad21\Models\Users;
use Esquadrao21\Squad21\Utils\Pages;
use Exception;
use Slim\Psr7\Response;

class ResetPassword extends Pages
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

    if (isset($_SESSION['uuid'])) {
      return $this->response->withHeader('Location', '/')->withStatus(302);
    }

    $body = $this->request->getParsedBody();
    if (is_array($body)) $resetPassword = $this->resetPassword($body);

    //Renderiza view
    $csrf = $GLOBALS['csrf'];
    $nameKey = $csrf->getTokenNameKey();
    $valueKey = $csrf->getTokenValueKey();

    //Renderiza view
    return $this->view->render($this->response, 'resetPassword.html', [
      'token' => [
        'nameKey'   => $nameKey,
        'valueKey'  => $valueKey,
        'name'      => $this->request->getAttribute($nameKey),
        'value'     => $this->request->getAttribute($valueKey)
      ],
      'resetPassword'      => $resetPassword ?? NULL
    ]);
  }

  private function resetPassword(array $body): ?string
  {
    try {
      $this->users->email = $body['email'];

      $resetPassword = $this->users->resetPassword();

      return $body['email'];
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
}
