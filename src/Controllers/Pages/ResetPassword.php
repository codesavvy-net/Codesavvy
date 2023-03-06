<?php

namespace Esquadrao21\Squad21\Controllers\Pages;

use Esquadrao21\Squad21\Models\Enums\UserType;
use Esquadrao21\Squad21\Models\Users;
use Esquadrao21\Squad21\Utils\Captcha;
use Esquadrao21\Squad21\Utils\Pages;
use Esquadrao21\Squad21\Utils\SendMail;
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

    if (isset($body['g-recaptcha-response']))
      $captcha = Captcha::verify($body['g-recaptcha-response']);

    if (is_array($body) && isset($captcha) && $captcha)
      $resetPassword = $this->resetPassword($body);

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
      'resetPassword'       => $resetPassword ?? NULL,
      'captcha'             => $captcha ?? NULL,
      'captcha_public'      => $_ENV['CAPTCHA_PUBLIC']
    ]);
  }

  private function resetPassword(array $body): ?string
  {
    try {
      $this->users->email = $body['email'];

      $resetPassword = $this->users->resetPassword();

      if (!is_null($resetPassword)) {
        $sendEmail = new SendMail();
        $sendEmail->addAddress($this->users->email);
        $sendEmail->subject("{$_ENV['NAME']} - Olá {$this->users->name} recupere sua conta!");
        $sendEmail->msgHTML('resetPassword.html', [
          "name" => $this->users->name,
          "link" => $_ENV['URL'] . "/recriar_senha?hash={$resetPassword}&email={$this->users->email}"
        ]);
        $sendEmail->send();
      }

      return $body['email'];
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
}
