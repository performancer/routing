<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Routing\Contract\RequestHandler;
use Routing\Contract\Response as ResponseInterface;
use Routing\Request;
use Routing\RequestHandler\Router;
use Routing\Response\Response;
use Routing\Route;

$handler = new class implements RequestHandler {
    public function handle(Request $request): ResponseInterface
    {
        $id = $request->params('id');
        return new Response(sprintf('Hey, we found item with id %s', $id), 200);
    }
};

$router = new Router;
$router->add(new Route('/item/{id<\d+>}', $handler));
$router->handle(new Request('/item/42'))->send();
