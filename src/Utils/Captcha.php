<?php
// Arquivo de Conexão com Banco de Dados
namespace Esquadrao21\Squad21\Utils;

// Classe de conexão
class Captcha
{
   public static function verify(string $response): bool
   {
      $ch = curl_init('https://hcaptcha.com/siteverify');
      $data = array(
         'response'  => $response,
         'secret'    => $_ENV['CAPTCHA_SECRET']
      );

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($ch);

      curl_close($ch);

      if ($response === false)
         return false;
      return json_decode($response)->success;
   }
}
