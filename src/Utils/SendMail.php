<?php
// Arquivo de Conexão com Banco de Dados
namespace Esquadrao21\Squad21\Utils;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Classe de conexão
class SendMail
{
   private PHPMailer $mail;

   public function __construct()
   {
      $this->mail = new PHPMailer();
      $this->mail->isSMTP();
      $this->mail->CharSet = 'UTF-8';

      if ($_ENV['ENVIRONMENT'] == "development")
         $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
      else
         $this->mail->SMTPDebug = SMTP::DEBUG_OFF;

      $this->mail->Host = $_ENV['EMAIL_HOST'];
      $this->mail->Port = $_ENV['EMAIL_PORT'];
      $this->mail->SMTPAuth = $_ENV['EMAIL_AUTH'];
      $this->mail->Username = $_ENV['EMAIL_USER'];
      $this->mail->Password = $_ENV['EMAIL_PASS'];
      $this->mail->setFrom($_ENV['EMAIL_MAIL'], $_ENV['EMAIL_NAME']);
   }

   public function addReplyTo(string $email): SendMail
   {
      $this->mail->addReplyTo($email);
      return $this;
   }
   public function addAddress(string $email): SendMail
   {
      $this->mail->addAddress($email);
      return $this;
   }
   public function addBCC(string $email): SendMail
   {
      $this->mail->addBCC($email);
      return $this;
   }
   public function subject(string $subject): SendMail
   {
      $this->mail->Subject = $subject;
      return $this;
   }
   public function msgHTML(string $template, array $context = []): SendMail
   {
      $loader = new FilesystemLoader(__DIR__ . DS . '..' . DS . 'Views' . DS . 'Emails');
      $twig = new Environment($loader);
      $html = $twig->render($template, $context);

      $email = explode('#noHtml', $html);

      die($email[0]);
      $this->mail->msgHTML($email[0]);
      $this->mail->AltBody = $email[1];
      return $this;
   }
   public function addAttachment(string $file): SendMail
   {
      if (file_exists($file))
         $this->mail->addAttachment($file);
      else
         throw new Exception('File not found!');
      return $this;
   }

   public function send(): bool|string
   {
      if ($this->mail->send())
         return true;
      return $this->mail->ErrorInfo;
   }
}
