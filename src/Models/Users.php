<?php

namespace Esquadrao21\Squad21\Models;

use Esquadrao21\Squad21\Models\Enums\UserType;
use Esquadrao21\Squad21\Utils\Connection;
use Esquadrao21\Squad21\Utils\Model;
use Exception;

class Users extends Model
{

  /**
   * UUID do usuário
   * @var string
   */
  protected string $uuid;

  /**
   * UUID do usuário
   * @var boolean
   */
  protected int $status;

  /**
   * Nome completo do usuário
   * @var string
   */
  protected string $name;

  /**
   * Nome de Usuário do usuário
   * @var string
   */
  protected string $username;

  /**
   * E-mail do usuário
   * @var string
   */
  protected string $email;

  /**
   * Sobre do usuário
   * @var string
   */
  protected ?string $bio;

  /**
   * Tipo de usuário do usuário
   * @var string
   */
  protected string $type;

  /**
   * Hash de Senha
   * @var string
   */
  protected string $password;

  /**
   * Token temporário
   * @var string
   */
  protected ?string $verify_token;

  /**
   * Token temporário
   * @var string
   */
  protected ?string $verify_timestamp;

  //Provisório deve ser removido, quando começar a construção da pagina
  public function __construct()
  {
    parent::__construct(Connection::connect(), "squad21_user");

    $res = $this->getColumn('uuid', 'be90e220-9809-4cff-8d63-0e09c146fa30');
  }

  /**
   * Puxar ID do Usuário
   * @return string
   */
  public function getUuid(): string
  {
    return $this->uuid;
  }

  /**
   * Faz a autenticação do Usuário
   * @param string $username
   * @param string $password
   * @return bool false se a senha estiver incorreta
   */
  public function signIn(string $username, string $password): bool
  {
    // chama o método getColumn passando o nome da coluna e o valor do nome de usuário
    $this->getColumn('username', $username);

    // verifica se a senha fornecida corresponde à senha armazenada no banco de dados para este usuário
    if (password_verify($password, ($this->password ?? ''))) {
      // se a senha estiver correta, define algumas variáveis de sessão e redireciona o usuário para a página inicial
      $_SESSION['uuid'] = $this->uuid;
      $_SESSION['name'] = $this->name;
      $_SESSION['type'] = $this->type;
      header('Location: /');
      exit;
    } else {
      // se a senha estiver incorreta, retorna false
      return false;
    }
  }

  /**
   * Reset Password
   * @return string Link de recuperação
   */
  public function resetPassword(): ?string
  {
    $res = $this->getColumn('email', $this->email);

    if (!$res) return null;

    $this->verify_token = bin2hex(random_bytes(15));
    $this->verify_timestamp = date("Y-m-d H:i:s", (time() + $_ENV['ACCOUNT_SECONDS_HASH']));

    if (isset($this->uuid))
      $this->alterColumn('uuid', $this->uuid);

    if (isset($this->verify_token))
      return $this->verify_token;
    return null;
  }

  /**
   * Recreate Password
   * @return string Link de recuperação
   */
  public function recreatePassword(string $hash): bool
  {
    $res = $this->getColumn('email', $this->email);

    if (!($res
      && $this->verify_token == $hash
      && (isset($this->verify_timestamp) && strtotime($this->verify_timestamp) >= time())
    )) return false;
    return true;
  }

  public function change()
  {
    $this->verify_timestamp = null;
    $this->verify_token = null;

    return $this->alterColumn('uuid', $this->uuid);
  }

  /**
   * Define Username
   * @param string $username
   * @return void
   */
  public function setUsername(string $username): void
  {
    // Verifica se a string tem pelo menos 5 caracteres
    if (strlen($username) < 5) // Se a string tem menos de 5 caracteres
      throw new Exception("Nome de usuário inválido"); // Lança uma exceção com a mensagem "Nome de usuário inválido" e código de erro 1000

    // Verifica se a string contém apenas caracteres válidos
    if (preg_match('/^[a-z][a-z0-9_-]*$/i', $username)) // Se a string contém apenas caracteres alfanuméricos em minúsculas, underline ou traço e começa com uma letra minúscula
      $this->username = $username; // String válida
    else
      throw new Exception("Nome de usuário inválido"); // Se a string não for válida, lança uma exceção com a mensagem "Nome de usuário inválido" e código de erro 1000
  }

  /**
   * Define E-mail
   * @param string $email
   * @return void
   */
  public function setEmail(string $email): void
  {
    // Verifica se o e-mail é válido
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) // Se o e-mail for válido de acordo com a função filter_var com o filtro FILTER_VALIDATE_EMAIL
      $this->email = $email; // Retorna o e-mail
    else
      throw new Exception("Endereço de e-mail inválido"); // Se o e-mail não for válido, lança uma exceção com a mensagem "Endereço de e-mail inválido" e código de erro 1001
  }

  /**
   * Define Senha
   * @param string $password
   * @return void
   */
  public function setPassword(string $password): void
  {
    // Verifica se a senha tem pelo menos 8 caracteres
    if (strlen($password) < 8) { // Se a senha tiver menos de 8 caracteres
      throw new Exception("A senha deve ter no mínimo 8 caracteres"); // Lança uma exceção
    }

    // Verifica se a senha tem no máximo 125 caracteres
    if (strlen($password) > 125) { // Se a senha tiver mais de 125 caracteres
      throw new Exception("A senha deve ter no máximo 125 caracteres"); // Lança uma exceção
    }

    // Verifica se a senha tem pelo menos um número, uma letra maiúscula e uma letra minúscula
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', $password)) { // Se a senha não tiver pelo menos um número, uma letra maiúscula e uma letra minúscula
      throw new Exception("A senha deve conter pelo menos um número, uma letra maiúscula e uma letra minúscula"); // Lança uma exceção
    }

    // Verifica se a senha está em um arquivo de senhas inseguras
    $insecure_password = file(__DIR__ . DS . '..' . DS . 'Resources' . DS . 'insecure_password.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Carrega o arquivo de senhas inseguras em um array
    if (in_array(strtolower($password), $insecure_password)) { // Se a senha estiver no array de senhas inseguras
      throw new Exception("A senha não é segura!"); // Lança uma exceção
    }

    // Se a senha passar por todas as verificações acima é convertida em hash
    $this->password = password_hash($password, PASSWORD_DEFAULT);
  }

  /**
   * Define Tipo
   * @param UserType $type
   * @return void
   */
  public function setType(UserType $type): void
  {
    // Verifica se o tipo de usuário recebido é ADMIN ou MODERATOR
    if ($type == UserType::ADMIN || $type == UserType::MODERATOR) {
      // Se for, lança uma exceção informando que o tipo de usuário não é permitido
      throw new Exception("Tipo de Usuário não permitido");
    }

    // Atribui o valor numérico correspondente ao tipo de usuário ao objeto atual
    $this->type = $type->value;
  }
}
