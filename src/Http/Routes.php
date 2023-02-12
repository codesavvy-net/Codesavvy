<?php

namespace Esquadrao21\Squad21\Routes;

use Esquadrao21\Squad21\Controllers\Pages\About;
use Esquadrao21\Squad21\Controllers\Pages\Home;

//Rotas de acesso
$app->get('/', Home::class);
$app->get('/sobre', About::class);
