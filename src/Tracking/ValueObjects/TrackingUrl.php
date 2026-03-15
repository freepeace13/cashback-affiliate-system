<?php

namespace CashbackAffiliateSystem\Tracking\ValueObjects;

use InvalidArgumentException;

final class TrackingUrl
{
    public function __construct(private string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid tracking URL');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}