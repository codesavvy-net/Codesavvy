<?php

namespace Esquadrao21\Squad21\Routes;

use Esquadrao21\Squad21\Controllers\Pages\About;
use Esquadrao21\Squad21\Controllers\Pages\Home;
use Esquadrao21\Squad21\Controllers\Pages\Logout;
use Esquadrao21\Squad21\Controllers\Pages\Profile;
use Esquadrao21\Squad21\Controllers\Pages\RecreatePassword;
use Esquadrao21\Squad21\Controllers\Pages\ResetPassword;
use Esquadrao21\Squad21\Controllers\Pages\SignIn;
use Esquadrao21\Squad21\Controllers\Pages\SignUp;
use Slim\Interfaces\RouteCollectorProxyInterface;

//Rotas de acesso
$app->get('[/]', Home::class);

$app->map(['GET', 'POST'], '/entrar[/]', SignIn::class);

$app->map(['GET', 'POST'], '/registrar[/]', SignUp::class);

$app->get('/desconectar[/]', Logout::class);

$app->map(['GET', 'POST'], '/recuperar_senha[/]', ResetPassword::class);

$app->map(['GET', 'POST'], '/recriar_senha[/]', RecreatePassword::class);

$app->get('/perfil[/]', Profile::class);

//POG - Temporário
$app->get('/api/talents.json', function () {
?>
  [
  {
  "id": 1,
  "name": "Juninho",
  "pSalarial": 1000,
  "mTrabalho": "PJ",
  "profissao": "Product Owner",
  "image": "https://raw.githubusercontent.com/BrunoGCSousa/squad-21/main/img/profile-pic.jpg"
  },
  {
  "id": 2,
  "name": "Serginho",
  "pSalarial": 1000,
  "mTrabalho": "PJ",
  "profissao": "Dev Back End",
  "image": "https://raw.githubusercontent.com/BrunoGCSousa/squad-21/main/img/profile-pic.jpg"
  },
  {
  "id": 3,
  "name": "Bruninho",
  "pSalarial": 1000,
  "mTrabalho": "PJ",
  "profissao": "Dev Front End",
  "image": "https://raw.githubusercontent.com/BrunoGCSousa/squad-21/main/img/profile-pic.jpg"
  },
  {
  "id": 4,
  "name": "Jorginho",
  "pSalarial": 1000,
  "mTrabalho": "PJ",
  "profissao": "Designer gráfico",
  "image": "https://raw.githubusercontent.com/BrunoGCSousa/squad-21/main/img/profile-pic.jpg"
  },
  {
  "id": 5,
  "name": "Celsinho",
  "pSalarial": 1000,
  "mTrabalho": "PJ",
  "profissao": "Dev Front End",
  "image": "https://raw.githubusercontent.com/BrunoGCSousa/squad-21/main/img/profile-pic.jpg"
  },
  {
  "id": 6,
  "name": "Dersinho",
  "pSalarial": 1000,
  "mTrabalho": "PJ",
  "profissao": "Dev Front End",
  "image": "https://raw.githubusercontent.com/BrunoGCSousa/squad-21/main/img/profile-pic.jpg"
  },
  {
  "id": 7,
  "name": "Pedrinho",
  "pSalarial": 1000,
  "mTrabalho": "PJ",
  "profissao": "Dev Front End",
  "image": "https://raw.githubusercontent.com/BrunoGCSousa/squad-21/main/img/profile-pic.jpg"
  },
  {
  "id": 8,
  "name": "Carlinho",
  "pSalarial": 1000,
  "mTrabalho": "PJ",
  "profissao": "Dev Front End",
  "image": "https://raw.githubusercontent.com/BrunoGCSousa/squad-21/main/img/profile-pic.jpg"
  },
  {
  "id": 9,
  "name": "Fabinho",
  "pSalarial": 1000,
  "mTrabalho": "PJ",
  "profissao": "Dev Front End",
  "image": "https://raw.githubusercontent.com/BrunoGCSousa/squad-21/main/img/profile-pic.jpg"
  },
  {
  "id": 10,
  "name": "Fezinho",
  "pSalarial": 1000,
  "mTrabalho": "PJ",
  "profissao": "Dev Front End",
  "image": "https://raw.githubusercontent.com/BrunoGCSousa/squad-21/main/img/profile-pic.jpg"
  }
  ]
<?php
  exit;
});
