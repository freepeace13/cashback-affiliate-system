<?php

final class Money
{
    public function __construct(
        private int $amountInMinor,
        private string $currency,
    ) {
        if ($amountInMinor < 0) {
            throw new InvalidArgumentException('Money amount cannot be negative.');
        }

        if (trim($currency) === '') {
            throw new InvalidArgumentException('Currency cannot be empty.');
        }
    }

    public function amountInMinor(): int
    {
        return $this->amountInMinor;
    }

    public function currency(): string
    {
        return $this->currency;
    }
}