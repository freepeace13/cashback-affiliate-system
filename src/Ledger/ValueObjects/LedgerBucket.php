<?php

namespace CashbackAffiliateSystem\Ledger\ValueObjects;  

use InvalidArgumentException;

final class LedgerBucket
{
    public const PENDING = 'pending';
    public const AVAILABLE = 'available';
    public const RESERVED = 'reserved';
    public const PAID = 'paid';

    public function __construct(
        private string $value,
    ) {
        if (! in_array($value, [self::PENDING, self::AVAILABLE, self::RESERVED, self::PAID])) {
            throw new InvalidArgumentException('Invalid bucket value');
        }
    }

    public static function pending(): self { return new self(self::PENDING); }
    public static function available(): self { return new self(self::AVAILABLE); }
    public static function reserved(): self { return new self(self::RESERVED); }
    public static function paid(): self { return new self(self::PAID); }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value();
    }
}