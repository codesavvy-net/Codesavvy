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
   static protected $table;

   // Função que faz a conexão com o banco de dados
   static public function connect()
   {
      try{

         self::$conn = new PDO('mysql:host'.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'],$_ENV['DB_USER'],$_ENV['DB_PASS']);

      }catch (PDOException $e){
         // Caso a conexão de algum erro, exibe uma menssagem de erro
         echo 'Erro de conexão';
      }
   }

   /**
    * Busca todas a colunas de uma tabela
    * @return array
   */
   static function getAll():array
   {
      $busca = self::$conn->prepare("SELECT * FROM ".self::$table);
      $busca->execute();
      return $busca->fetchAll('PDO::FETCH_ASSOC');

   }

    /**
    * Busque o valor específico em uma coluna especifica
    * @param $column string enviar o nome da coluna especifica para a busca
    * @param $value string passar o valor especifico que deseja buscar
    * @return ?array
   */
  static function getColumn(string $column, string $value):?array
  {
     $busca = self::$conn->prepare("SELECT * FROM ".self::$table." WHERE {$column} = :value");
     $busca->bindParam(':value', $value);
     $busca->execute();

     // Se encontrar um linha na tabela, retorna um array com os valores
     if($busca->rowCount())
        return $busca->fetch('PDO::FETCH_ASSOC');

      // Se não, retorna um valor null
     return null;

  }

   /**
    * Busque o valor específico em uma coluna especifica
    * @param $column string enviar o nome da coluna especifica para a busca
    * @param $specific string passar o valor especifico que deseja buscar
    * @return ?array
   */
  static function alterColumn(string $column, string $value, array $columns):?array
  {

   $seters = null;

   foreach($columns as $key => $item){
    $seters .= "{$key}=':{$key}',";
   }


   $seters = substr($seters, 0, -1);
    $altera = self::$conn->prepare("UPDATE ".self::$table." SET {$seters}  WHERE {$column} = :value");

   $altera->bindParam(':value', $value);

   foreach($columns as $key => $item){
    $altera->bindParam(":{$key}", $item);
   }
     $altera->execute();

     // Se encontrar um linha na tabela, retorna um array com os valores
     if($altera->rowCount())
        return self::getColumn($column, $value);

      // Se não, retorna um valor null
     return null;

  }
   

 }