<?php

namespace Cashback\Offers;

class CashbackRate
{
    public function __construct(private string $value)
    {
        if (trim($value) === '') {
            throw new \Exception('Cashback rate cannot be empty');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value();
    }
}
