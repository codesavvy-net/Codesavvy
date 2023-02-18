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
