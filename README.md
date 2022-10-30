# routing

A minimal router to direct traffic

## Usage

Create a path with parameter and match it and execute a function once it's routed.

```php
<?php

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
$request = new Request(
    $_SERVER['REMOTE_ADDR'],
    $_SERVER['REQUEST_URI'],
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['CONTENT_TYPE'],
);
$response = $router->handle($request);
$response->send();
```

TIP #1: You may handle RoutingExceptions with your custom _page not found_ response.

```php
try {
    $response = $router->handle($request);
} catch (RoutingException $e) {
    $response = new Response('Page not found!', 404);
}
```
TIP #2: If you are using json/application content type, the request will parse it out for you and the data is easily accessible from the request object.

```php
$request = new Request(...);
$body = $request->body();
$name = $body['name'];
$email = $body['email'];
$amount = (int)$body['amount'];
```