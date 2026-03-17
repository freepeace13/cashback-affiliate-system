<?php

namespace Cashback\Transactions\ValueObjects;

final class TransactionID
{
    public function __construct(private string $value)
    {
        if (trim($value) === '') {
            throw new \Exception('Transaction ID cannot be empty');
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