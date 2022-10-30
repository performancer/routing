<?php

declare(strict_types=1);

namespace Routing;

use Routing\Contract\RequestHandler;

final class Route
{
    public function __construct(
        private readonly string $path,
        private readonly RequestHandler $handler,
    ) {
    }

    public function path(): string
    {
        return $this->path;
    }

    public function handler(): RequestHandler
    {
        return $this->handler;
    }
}
