<?php

namespace CashbackAffiliateSystem\Shared\ValueObjects;

use InvalidArgumentException;

final class Money
{
    private int $amount;
    
    private Currency $currency;

    public function __construct(int $amount, string $currency)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Money amount cannot be negative.');
        }

        $this->amount = $amount;
        $this->currency = new Currency($currency);
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }
}