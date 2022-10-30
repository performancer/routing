<?php

declare(strict_types=1);

namespace Routing\Parameter;

class Parameters
{
    /** @var string[] */
    private array $parameters = [];

    public function get(string $key): string
    {
        return $this->parameters[$key];
    }

    public function set(string $key, string $value): self
    {
        $clone = clone $this;
        $clone->parameters[$key] = $value;

        return $clone;
    }
}
