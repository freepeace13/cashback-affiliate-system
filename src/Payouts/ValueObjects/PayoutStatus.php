<?php

namespace CashbackAffiliateSystem\Payouts\ValueObjects;

use InvalidArgumentException;

class PayoutStatus
{
    public const REQUESTED = 'requested';
    public const APPROVED = 'approved';
    public const PROCESSING = 'processing';
    public const PAID = 'paid';
    public const FAILED = 'failed';

    public function __construct(private string $value) {
        if (! in_array($value, [self::REQUESTED, self::APPROVED, self::PROCESSING, self::PAID, self::FAILED])) {
            throw new InvalidArgumentException('Invalid payout status');
        }
    }

    public static function requested(): self { return new self(self::REQUESTED); }
    public static function approved(): self { return new self(self::APPROVED); }
    public static function processing(): self { return new self(self::PROCESSING); }
    public static function paid(): self { return new self(self::PAID); }
    public static function failed(): self { return new self(self::FAILED); }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value();
    }
}