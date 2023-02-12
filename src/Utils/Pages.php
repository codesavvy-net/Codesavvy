<?php

namespace Esquadrao21\Squad21\Utils;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;

abstract class Pages
{

  /**
   * Objeto Request
   * @var Request
   */
  protected $request;

  /**
   * Objeto Response
   * @var Response
   */
  protected $response;

  /**
   * Argumentos passados na URI
   * @return array
   */
  protected $args;

  /**
   * Objeto para renderização do template
   * @return void
   */
  protected $view;

  /**
   * Objeto magico do PHP
   * @param $request Request
   * @param $response Response
   * @param $args Argumentos da URI
   * @return Response
   */
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
