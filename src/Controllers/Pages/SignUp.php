<?php

namespace Esquadrao21\Squad21\Controllers\Pages;

use Esquadrao21\Squad21\Models\Enums\UserType;
use Esquadrao21\Squad21\Models\Users;
use Esquadrao21\Squad21\Utils\Captcha;
use Esquadrao21\Squad21\Utils\Pages;
use Exception;
use Slim\Psr7\Response;

class SignUp extends Pages
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

    if (isset($body['g-recaptcha-response']))
      $captcha = Captcha::verify($body['g-recaptcha-response']);

    if (is_array($body) && isset($captcha) && $captcha)
      $signUp = $this->signUp($body);

    //Renderiza view
    $csrf = $GLOBALS['csrf'];
    $nameKey = $csrf->getTokenNameKey();
    $valueKey = $csrf->getTokenValueKey();

    //Renderiza view
    return $this->view->render($this->response, 'signUp.html', [
      'token' => [
        'nameKey'   => $nameKey,
        'valueKey'  => $valueKey,
        'name'      => $this->request->getAttribute($nameKey),
        'value'     => $this->request->getAttribute($valueKey)
      ],
      'signUp'              => $signUp ?? null,
      'captcha'             => $captcha ?? NULL,
      'captcha_public'      => $_ENV['CAPTCHA_PUBLIC']
    ]);
  }

  private function signUp(array $body): array | string | null
  {
    try {
      $this->users->name = $body['name'];

      $this->users->name;
      $this->users->username = $body['username'];
      $this->users->email = $body['email'];
      $this->users->password = $body['password'];
      $this->users->type = UserType::from($body['type']);

      return $this->users->insert();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
}
