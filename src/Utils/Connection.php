<?php
// Arquivo de Conexão com Banco de Dados
namespace Esquadrao21\Squad21\Utils;

use PDO;
use PDOException;

// Classe de conexão
class Connection
{
   // Variavel que recebe a query de conexão
   static protected $conn;

   // Função que faz a conexão com o banco de dados
   public static function connect()
   {
      try {
         if (empty(self::$conn)) {
            self::$conn = new PDO("{$_ENV['DB_ADAPTER']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASS']);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
         }
         return self::$conn;
      } catch (PDOException $e) {
         // Caso a conexão de algum erro, exibe uma menssagem de erro
         die('Erro de conexão com a base de dados');
      }
   }
}
