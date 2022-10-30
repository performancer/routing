<?php

declare(strict_types=1);

namespace Routing;

use Routing\Contract\ResponseInterface;
use Routing\Contract\ParameterParserInterface;
use Routing\Exception\RoutingException;
use Routing\Helper\PathQueue;
use Routing\Parameter\Parameters;

class Router
{
    /** @var Route[] */
    private array $routes;

    public function __construct(
        private readonly ParameterParserInterface $parser,
    ) {
        $this->routes = [];
    }

    public function add(Route $route): void
    {
        $this->routes[] = $route;
    }

    /**
     * @param Request $request
     * @return ResponseInterface
     * @throws RoutingException
     */
    public function handle(Request $request): ResponseInterface
    {
        $queue = PathQueue::fromPath($request->path());
        [$closure, $params] = $this->find($queue, new Parameters(), $this->routeTree());
        $request = $request->withParams($params);

        return $closure($request);
    }

    private function routeTree(): array
    {
        $tree = [];
        foreach ($this->routes as $route) {
            $current = &$tree;

            foreach ($route->route() as $part) {
                $current[$part] = $current[$part] ?? [];
                $current = &$current[$part];
            }

            $current[''] = $route->getClosure();
        }

        return $tree;
    }

    /**
     * @param PathQueue $queue
     * @param Parameters $params
     * @param array $routes
     * @return array
     * @throws RoutingException
     */
    private function find(PathQueue $queue, Parameters $params, array $routes): array
    {
        $part = $queue->front();

        foreach ($routes as $route => $handler) {
            if (preg_match($this->parser->pattern((string)$route), $part)) {
                if ($this->parser->isParameter((string)$route)) {
                    $params = $params->set($this->parser->parameterKey((string)$route), $part);
                }

                if (is_array($handler)) {
                    return $this->find($queue->pop(), $params, $handler);
                }

                return [$handler, $params];
            }
        }

        throw new RoutingException();
    }
}
