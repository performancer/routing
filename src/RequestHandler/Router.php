<?php

declare(strict_types=1);

namespace Routing\RequestHandler;

use Routing\Contract\RequestHandler;
use Routing\Contract\Response;
use Routing\Exception\RoutingException;
use Routing\Request;
use Routing\Route;
use Routing\Service\ParameterParser;
use Routing\Service\ParameterPasser;
use Routing\Service\RouteTreeBuilder;

final class Router implements RequestHandler
{
    /**
     * @param Route[] $routes
     */
    public function __construct(
        private array $routes = [],
    ) {
    }

    public function add(Route $route): self
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     * @throws RoutingException
     */
    public function handle(Request $request): Response
    {
        $parser = new ParameterParser;
        $passer = new ParameterPasser($parser);
        $builder = new RouteTreeBuilder($parser, $passer);

        return $builder->build($this->routes)->handle($request);
    }
}