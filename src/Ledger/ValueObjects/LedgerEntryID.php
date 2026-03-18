<?php

namespace Cashback\Ledger\ValueObjects;

use InvalidArgumentException;

final class LedgerEntryID
{
    public function __construct(
        private string $value,
    ) {
        if (trim($value) === '') {
            throw new InvalidArgumentException('Ledger entry ID cannot be empty');
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