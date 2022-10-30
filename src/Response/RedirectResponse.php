<?php

declare(strict_types=1);

namespace Routing\Response;

use Routing\Contract\Response as ResponseInterface;

final class RedirectResponse implements ResponseInterface
{
    public function __construct(
        private readonly string $url,
    ) {
    }

    public function send(): void
    {
        header('Location: ' . $this->url);
    }
}
