<?php

declare(strict_types=1);

namespace Routing\Service;

use Routing\RequestHandler\RouteGroup;
use Routing\Route;

final class RouteTreeBuilder
{
    public function __construct(
        private readonly ParameterParser $parser,
        private readonly ParameterPasser $passer,
    ) {
    }

    /**
     * Builds a step-by-step tree structure for routes where the leaf nodes are the given request handlers
     *
     * @param Route[] $routes
     * @return RouteGroup
     */
    public function build(array $routes): RouteGroup
    {
        $root = new RouteGroup($this->parser, $this->passer);
        foreach ($routes as $route) {
            $current = $root;
            foreach (PathExploder::explode($route->path()) as $fragment) {
                $node = $current->get($fragment) ?? new RouteGroup($this->parser, $this->passer);
                $current->set($fragment, $node);
                $current = $node;
            }

            $current->set('', $route->handler());
        }

        return $root;
    }
}
