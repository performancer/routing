<?php

declare(strict_types=1);

namespace Routing;

use Routing\Service\PathExploder;
use Routing\Service\PathQueue;

final class Request
{
    /** @var array<string, string> */
    private array $params;
    private PathQueue $pathQueue;

    public function __construct(
        private readonly string $path,
        private readonly string $remote = '',
        private readonly string $method = '',
        private readonly string $contentType = '',
    ) {
        $this->pathQueue = new PathQueue(PathExploder::explode($path));
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

    public function params(string $key): string
    {
        return $this->params[$key];
    }

    public function withParams(string $key, string $value): self
    {
        $clone = clone $this;
        $clone->params[$key] = $value;

        return $clone;
    }

    public function pathQueue(): PathQueue
    {
        return $this->pathQueue;
    }

    public function withPathQueue(PathQueue $queue): self
    {
        $clone = clone $this;
        $clone->pathQueue = $queue;

        return $clone;
    }
}
