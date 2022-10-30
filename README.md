# routing

A routing system that can also parse url parameters

## Usage

Create a path with parameter and match it and execute a function once it's routed.

```php
<?php

use Routing\Contract\RequestHandler;
use Routing\Contract\Response as ResponseInterface;
use Routing\Request;
use Routing\Response\Response;
use Routing\Route;
use Routing\Router;

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