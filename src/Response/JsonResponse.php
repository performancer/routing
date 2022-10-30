<?php

declare(strict_types=1);

namespace Routing\Response;

use Routing\Contract\Response as ResponseInterface;

final class JsonResponse implements ResponseInterface
{
    public function __construct(
        private readonly array $content,
        private readonly int $status,
    ) {
    }

    public function send(): void
    {
        http_response_code($this->status);
        header('Content-Type: application/json');

        try {
            echo json_encode($this->content, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            echo 'A JSON encode error occurred: ' . $e;
        }
    }
}
