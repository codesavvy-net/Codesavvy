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

   // A string $seters é cortada para remover a última vírgula.
   $seters = substr($seters, 0, -1);

   // A variável $altera é preenchida com uma instrução SQL que irá atualizar a tabela self::$table com os valores definidos em $seters e onde a coluna específica (definida por $column) é igual ao valor específico (definido por $value).
    $altera = self::$conn->prepare("UPDATE ".self::$table." SET {$seters}  WHERE {$column} = :value");

    // O método bindParam é usado para ligar o valor de $value ao placeholder :value na instrução SQL
   $altera->bindParam(':value', $value);

   // Outro loop foreach é usado para iterar sobre o array $columns e ligar cada valor ao seu respectivo placeholder na instrução SQL.
   foreach($columns as $key => $item){
    $altera->bindParam(":{$key}", $item);
   }

      // O método execute é usado para executar a instrução SQL.
     $altera->execute();

     // Se a consulta encontrar uma linha na tabela, ela retornará um array com os valores da coluna específica (obtido pelo método getColumn)
     if($altera->rowCount())
        return self::getColumn($column, $value);

      // Se a consulta não encontrar nenhuma linha na tabela, ela retornará o valor null.
     return null;

  }


   /**
    * Este é um método que exclui uma linha específica da tabela. Ele tem dois parâmetros: $columne $value, que especificam a coluna e o valor para deletar respectivamente.
    * @param $column string enviar o nome da coluna especifica para ser deletada
    * @param $value string passar o valor especifico da coluna que deseja deletar
    * @return bool
   */
  static function deleteColumn(string $column, string $value):bool
  {
      //Essa linha usa o objeto de $conn conexão para preparar uma consulta SQL para deletar uma linha da tabela self::$table
     $delete = self::$conn->prepare("DELETE '{$column}' FROM ".self::$table." WHERE {$value} = :value");
     $delete->bindParam(':value', $value);

     //// O método execute é usado para executar a instrução SQL.
     $delete->execute();

     // Verifica se a coluna foi deletada, se sim retorna true, se não retorna false.
     return (bool) $delete->rowCount();

  }
   

 }