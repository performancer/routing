<?php

declare(strict_types=1);

namespace Routing\Contract;

interface ParameterParserInterface
{
    /**
     * Returns the suitable pattern for regex that should be used for this part of the route
     *
     * @param string $part
     * @return string
     */
    public function pattern(string $part): string;

    /**
     * Checks if the given part of the route is a variable slot
     *
     * @param string $part
     * @return bool
     */
    public function isParameter(string $part): bool;

    /**
     * Parses the parameter key from the given part of the route
     *
     * @param string $part part of the route
     * @return string parameter key
     */
    public function parameterKey(string $part): string;
}
