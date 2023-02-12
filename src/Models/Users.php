<?php

namespace Esquadrao21\Squad21\Models;

class Users
{

  private string $id;
  private string $name;

  public function __construct()
  {
    $this->id = 'be90e220-9809-4cff-8d63-0e09c146fa30';
    $this->name = 'Nícola Serafim';
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }
}
