<?php

declare(strict_types=1);

namespace Routing\Response;

use Routing\Contract\ResponseInterface;

final class Response implements ResponseInterface
{
    public function __construct(
        private readonly string $content,
        private readonly int $status,
    ) {
    }

    public function send(): void
    {
        http_response_code($this->status);
        header('Content-Type: text/html; charset=UTF-8');
        echo $this->content;
    }
}
