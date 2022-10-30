<?php

declare(strict_types=1);

namespace Routing\Parameter;

use Routing\Contract\ParameterParserInterface;

/**
 * Parses parameters from route parts that are defined like {paramName<regexRequirement>} for example: {id</d+>}
 */
class ParameterParser implements ParameterParserInterface
{
    private string $paramStartChar = '{';
    private string $paramEndChar = '}';
    private string $patternDefStartChar = '<';
    private string $patternDefEndChar = '>';

    /**
     * {@inheritDoc}
     *
     * If the route part is a variable slot and the pattern requirement has been defined, this returns that pattern
     * Otherwise the pattern returned will accept any letter or digit
     *
     * If this route part is not a variable slot, the pattern will consist of itself.
     */
    public function pattern(string $part): string
    {
        if (!$this->isParameter($part)) {
            return '/^' . $part . '$/';
        }

        if (preg_match('/<(.*?)>}$/', $part, $match) > 0) {
            return '/^(' . $match[1] . ')$/';
        }

        return '/^([a-z0-9\-]+)$/';
    }

    /**
     * {@inheritdoc}
     *
     * Checks if this part of the url has been wrapped with parameter defining characters
     */
    public function isParameter(string $part): bool
    {
        return str_starts_with($part, $this->paramStartChar) && str_ends_with($part, $this->paramEndChar);
    }

    /**
     * {@inheritdoc}
     *
     * Drops the parameter defining characters and regex pattern definition
     */
    public function parameterKey(string $part): string
    {
        return preg_replace(
            '/' . $this->patternDefStartChar . '(.*?)' . $this->patternDefEndChar . '$/',
            '',
            substr($part, 1, -1)
        );
    }
}
