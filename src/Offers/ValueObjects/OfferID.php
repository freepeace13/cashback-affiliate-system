<?php

namespace Cashback\Offers\ValueObjects;

class OfferID
{
    public function __construct(private string $value)
    {
        if (trim($value) === '') {
            throw new \Exception('Offer ID cannot be empty');
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