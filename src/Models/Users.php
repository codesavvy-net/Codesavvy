<?php

namespace Esquadrao21\Squad21\Models;

class Users
{

  /**
   * UUID do usuário
   * @var string
   */
  private string $id;

  /**
   * Nome completo do usuário
   * @var string
   */
  private string $name;

  //Provisório deve ser removido, quando começar a construção da pagina
  public function __construct()
  {
    $this->id = 'be90e220-9809-4cff-8d63-0e09c146fa30';
    $this->name = 'Nícola Serafim';
  }

  /**
   * Puxar ID do Usuário
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * Puxar nome do Usuário
   * @return string
   */
  public function getName(): string
  {
    return $this->name;
  }
}
