<?php

declare(strict_types=1);

namespace Routing\Contract;

use Routing\Request;

interface RequestHandler
{
    public function handle(Request $request): Response;
}
