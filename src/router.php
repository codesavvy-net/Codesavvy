<?php

use Esquadrao21\Squad21\Controllers\About\AboutController;
use Esquadrao21\Squad21\Controllers\Home\HomeController;

$app->get('/', HomeController::class);
$app->get('/sobre', AboutController::class);
