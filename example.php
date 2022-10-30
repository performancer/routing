<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Routing\Contract\ResponseInterface;
use Routing\Parameter\ParameterParser;
use Routing\Request;
use Routing\Response\Response;
use Routing\Route;
use Routing\Router;

function controller(Request $request): ResponseInterface
{
    $id = $request->params('id');
    return new Response(sprintf('Hey, we found item with id %s', $id), 200);
}

$router = new Router(new ParameterParser());
$router->add(new Route('/item/{id<\d+>}', fn (Request $request) => controller($request)));
$request = new Request('127.0.0.1', '/item/42', 'GET', '');
$response = $router->handle($request);
$response->send();
