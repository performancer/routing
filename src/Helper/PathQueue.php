<?php

declare(strict_types=1);

namespace Routing\Helper;

final class PathQueue
{
    public function __construct(
        private readonly array $parts,
    ) {
    }

    public static function fromPath(string $path): PathQueue
    {
        if (str_starts_with($path, '/')) {
            $path = substr($path, 1);
        }

        return new PathQueue(explode('/', $path));
    }

    public function front(): string
    {
        return $this->parts[0] ?? '';
    }

    public function pop(): self
    {
        $parts = $this->parts;
        array_shift($parts);

        return new self($parts);
    }
}
