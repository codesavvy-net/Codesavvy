<?php

namespace Esquadrao21\Squad21\Models;

use Esquadrao21\Squad21\Utils\Connection;
use Esquadrao21\Squad21\Utils\Model;

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
  protected string $status;

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

  protected string $created_at;
  protected string $updated_at;

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
   * Puxar nome do Usuário
   * @return string
   */
  // public function getName(): ?string
  // {
  //   if (isset($this->name))
  //     return $this->name;
  //   return null;
  // }

  public function __get($name): mixed
  {
    if (isset($this->$name))
      return $this->$name;
    return null;
  }

  public function login(string $username, string $password): bool
  {
    $this->getColumn('username', $username);

    if (password_verify($password, ($this->password ?? ''))) {
      $_SESSION['uuid'] = $this->uuid;
      $_SESSION['name'] = $this->name;
      header('Location: /');
      exit;
    } else
      return false;
  }
}
