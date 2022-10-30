<?php

declare(strict_types=1);

namespace Routing\Service;

use Routing\Request;

final class ParameterPasser
{
    public function __construct(
        private readonly ParameterParser $parser,
    ) {
    }

    /**
     * Passes parameters to the request and returns it
     */
    public function pass(Request $request, string $pattern, string $value): Request
    {
        $parser = $this->parser;

        if ($parser->isParameter($pattern)) {
            $key = $parser->parameterKey($pattern);
            $request = $request->withParams($key, $value);
        }

        return $request;
    }
}