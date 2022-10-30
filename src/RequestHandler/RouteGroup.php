<?php

declare(strict_types=1);

namespace Routing\RequestHandler;

use Routing\Contract\RequestHandler;
use Routing\Contract\Response as ResponseInterface;
use Routing\Exception\RoutingException;
use Routing\Request;
use Routing\Service\ParameterParser;
use Routing\Service\ParameterPasser;

final class RouteGroup implements RequestHandler
{
    /** @var array<string, RequestHandler> */
    private array $routes;

    public function __construct(
        private readonly ParameterParser $parser,
        private readonly ParameterPasser $passer,
    ) {
        $this->routes = [];
    }

    public function get(string $key): ?RequestHandler
    {
        return $this->routes[$key] ?? null;
    }

    public function set(string $key, RequestHandler $handler): void
    {
        $this->routes[$key] = $handler;
    }

    /**
     * @throws RoutingException
     */
    public function handle(Request $request): ResponseInterface
    {
        $value = $request->pathQueue()->front();
        foreach ($this->routes as $route => $handler) {
            $pattern = $this->parser->pattern($route);
            if (preg_match($pattern, $value)) {
                $request = $this->passer->pass($request, $route, $value);
                $request = $request->withPathQueue($request->pathQueue()->pop());

                return $handler->handle($request);
            }
        }

        throw new RoutingException;
    }
}
