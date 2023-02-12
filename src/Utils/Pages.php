<?php

namespace Esquadrao21\Squad21\Utils;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;

abstract class Pages
{

  protected $request;
  protected $response;
  protected $args;
  protected $view;

  public function __invoke(Request $request, Response $response, array $args): Response
  {
    $this->request = $request;
    $this->response = $response;
    $this->args = $args;

    $this->view = Twig::fromRequest($request);

    return $this->action();
  }

  abstract protected function action(): Response;
}
