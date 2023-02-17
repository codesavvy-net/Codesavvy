<?php

namespace Esquadrao21\Squad21\Controllers\Pages;

use Esquadrao21\Squad21\Models\Enums\UserType;
use Esquadrao21\Squad21\Models\Users;
use Esquadrao21\Squad21\Utils\Pages;
use Esquadrao21\Squad21\Utils\SendMail;
use Exception;
use Slim\Psr7\Response;

class RecreatePassword extends Pages
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

    $hash = filter_input(1, 'hash', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mail = filter_input(1, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $body = $this->request->getParsedBody();

    $this->users->email = $mail;
    if ($this->users->recreatePassword($hash))
      $hashValid = true;

    if (is_array($body)) $recreatePassword = $this->recreatePassword($hash, $mail, $body);

    $csrf = $GLOBALS['csrf'];
    $nameKey = $csrf->getTokenNameKey();
    $valueKey = $csrf->getTokenValueKey();

    //Renderiza view
    return $this->view->render($this->response, 'recreatePassword.html', [
      'token' => [
        'nameKey'   => $nameKey,
        'valueKey'  => $valueKey,
        'name'      => $this->request->getAttribute($nameKey),
        'value'     => $this->request->getAttribute($valueKey)
      ],
      'hashValid'         => $hashValid ?? false,
      'recreatePassword'  => $recreatePassword ?? NULL
    ]);
  }

  private function recreatePassword(string $hash, string $mail, array $body)
  {
    try {
      if (isset($body['password'])) {
        $this->users->setPassword($body['password']);
        return $this->users->change();
      }
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
}
