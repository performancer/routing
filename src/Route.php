<?php

declare(strict_types=1);

namespace Routing;

use Closure;

class Route
{
    public function __construct(
        private readonly string $route,
        private readonly Closure $closure,
    ) {
    }

    public function route(): array
    {
        $route = $this->route;

        if (str_starts_with($route, '/')) {
            $route = substr($route, 1);
        }

        if (str_ends_with($route, '/')) {
            $route = substr($route, 0, -1);
        }

        if ($route !== '') {
            return explode('/', $route);
        }

        return [];
    }

    public function getClosure(): Closure
    {
        return $this->closure;
    }
}
