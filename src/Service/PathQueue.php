<?php

declare(strict_types=1);

namespace Routing\Service;

final class PathQueue
{
    public function __construct(
        private readonly array $parts,
    ) {
    }

    /**
     * Returns the first cell on the queue
     */
    public function front(): string
    {
        return $this->parts[0] ?? '';
    }

    /**
     * Returns a new instance of the queue without the first cell
     */
    public function pop(): self
    {
        $parts = $this->parts;
        array_shift($parts);

        return new self($parts);
    }
}
