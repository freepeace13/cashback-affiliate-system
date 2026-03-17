<?php

namespace Cashback\Shared\ValueObjects;

use InvalidArgumentException;

final class Currency
{
    private string $value;

    public function __construct(string $value)
    {
        if (trim($value) === '') {
            throw new InvalidArgumentException('Currency cannot be empty.');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}