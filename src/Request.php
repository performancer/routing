<?php

declare(strict_types=1);

namespace Routing;

use Routing\Parameter\Parameters;

class Request
{
    private Parameters $params;

    public function __construct(
        private readonly string $remote,
        private readonly string $path,
        private readonly string $method,
        private readonly string $contentType,
    ) {
        $this->params = new Parameters();
    }

    public function remoteAddress(): string
    {
        return $this->remote;
    }

    public function path(): string
    {
        $path = $this->path;

        if (str_ends_with($path, '/')) {
            $path = substr($path, 0, -1);
        }

        return $path;
    }

    public function params(string $key): string
    {
        return $this->params->get($key);
    }

    public function withParams(Parameters $params): self
    {
        $clone = clone $this;
        $clone->params = $params;

        return $clone;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function body(): array
    {
        if (strcasecmp($this->contentType, 'application/json') === 0) {
            $content = file_get_contents('php://input');

            return json_decode($content, true) ?? [];
        }

        return [];
    }
}
