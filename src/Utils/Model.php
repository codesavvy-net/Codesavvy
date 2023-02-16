<?php
// Arquivo de Conexão com Banco de Dados
namespace Esquadrao21\Squad21\Utils;

use Exception;
use Users;

// Classe de conexão
class Model
{
   public function __construct(
      private $conn,
      private string $table
   ) {
   }

   public function __get($name): mixed
   {
      if (isset($this->$name))
         return $this->$name;
      return null;
   }

   public function __set($name, $value): void
   {
      $method = 'set' . ucfirst($name);
      if (method_exists($this, $method)) {
         $this->$method($value);
      } else
      if (!is_callable(__CLASS__, $name))
         throw new Exception($name . ' not exist in Model', 0);
      else
         $this->$name = $value;
   }

   /**
    * Busca todas a colunas de uma tabela
    * @return array
    */
   protected function getAll(): array
   {
      $busca = $this->conn->prepare("SELECT * FROM " . $this->table);
      $busca->execute();
      return $busca->fetchAll('PDO::FETCH_ASSOC');
   }

   /**
    * Busque o valor específico em uma coluna especifica
    * @param $column string enviar o nome da coluna especifica para a busca
    * @param $value string passar o valor especifico que deseja buscar
    * @return ?array
    */
   protected function getColumn(string $column, string $value): void
   {
      $busca = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE {$column} = :value");
      $busca->bindParam(':value', $value);
      $busca->execute();

      if ($busca->rowCount()) {
         $res = $busca->fetch(\PDO::FETCH_ASSOC);
         foreach ($res as $key => $item)
            $this->{$key} = $item;
      }
   }

   /**
    * Busque o valor específico em uma coluna especifica
    * @param $column string enviar o nome da coluna especifica para a busca
    * @param $specific string passar o valor especifico que deseja buscar
    * @return ?array
    */
   protected function alterColumn(string $column, string $value, array $columns): ?array
   {
      $seters = null;

      foreach ($columns as $key => $item) {
         $seters .= "{$key}=':{$key}',";
      }

      // A string $seters é cortada para remover a última vírgula.
      $seters = substr($seters, 0, -1);

      // A variável $altera é preenchida com uma instrução SQL que irá atualizar a tabela self::$table com os valores definidos em $seters e onde a coluna específica (definida por $column) é igual ao valor específico (definido por $value).
      $altera = $this->conn->prepare("UPDATE " . $this->table . " SET {$seters}  WHERE {$column} = :value");

      // O método bindParam é usado para ligar o valor de $value ao placeholder :value na instrução SQL
      $altera->bindParam(':value', $value);

      // Outro loop foreach é usado para iterar sobre o array $columns e ligar cada valor ao seu respectivo placeholder na instrução SQL.
      foreach ($columns as $key => $item) {
         $altera->bindParam(":{$key}", $item);
      }

      // O método execute é usado para executar a instrução SQL.
      $altera->execute();

      // Se encontrar um linha na tabela, retorna um array com os valores
      if ($altera->rowCount())
         return $this->getColumn($column, $value);

      // Se não, retorna um valor null
      return null;
   }

   /**
    * Este é um método que exclui uma linha específica da tabela. Ele tem dois parâmetros: $columne $value, que especificam a coluna e o valor para deletar respectivamente.
    * @param $column string enviar o nome da coluna especifica para ser deletada
    * @param $value string passar o valor especifico da coluna que deseja deletar
    * @return bool
    */
   protected function deleteColumn(string $column, string $value): bool
   {
      //Essa linha usa o objeto de $conn conexão para preparar uma consulta SQL para deletar uma linha da tabela self::$table
      $delete = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE {$column} = :value");
      $delete->bindParam(':value', $value);

      //// O método execute é usado para executar a instrução SQL.
      $delete->execute();

      // Verifica se a coluna foi deletada, se sim retorna true, se não retorna false.
      return (bool) $delete->rowCount();
   }

   /**
    * Este é um método que adiciona uma linha específica na tabela. 
    * @return bool
    */
   public function insert(): array
   {
      $this->uuid = UUID::v4(); // Gera um UUID v4 para o objeto atual

      $sql = "INSERT INTO {$this->table} "; // Monta a query SQL para inserção de dados na tabela correspondente
      $columns = null; // Inicializa a string de colunas com null
      $interrogation = null; // Inicializa a string de interrogações com null
      $values = []; // Inicializa o array de valores com um array vazio

      // Para cada propriedade do objeto atual
      foreach (get_object_vars($this) as $key => $item) {
         // Se a propriedade não for 'table' nem 'conn'
         if (!($key == 'table' || $key == 'conn')) {
            // Adiciona o nome da coluna na string de colunas
            $columns .= "`{$key}`,";
            // Adiciona uma interrogação na string de interrogações
            $interrogation .= "?,";
            // Adiciona o valor da propriedade no array de valores
            array_push($values, $item);
         }
      }

      // Monta a string de consulta SQL com as colunas e interrogações geradas
      $sql .= "(" . substr($columns, 0, -1) . ") VALUES (" . substr($interrogation, 0, -1) . ")";

      // Prepara a query para inserção com os valores gerados
      $insert = $this->conn->prepare($sql);

      // Executa a query com os valores
      $insert->execute($values);

      return $this->getColumn('uuid', $this->uuid);
   }
}
