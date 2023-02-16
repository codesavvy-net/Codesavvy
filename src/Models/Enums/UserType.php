<?php

namespace Esquadrao21\Squad21\Models\Enums;

enum UserType: int
{
  case ADMIN = 1;
  case MODERATOR = 2;
  case PROGRAMMER = 3;
  case USER = 4;
}
