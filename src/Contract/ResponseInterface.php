<?php

declare(strict_types=1);

namespace Routing\Contract;

interface ResponseInterface
{
    public function send(): void;
}
