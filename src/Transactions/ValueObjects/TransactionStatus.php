<?php

final class TransactionStatus
{
    public const TRACKED = 'tracked';
    public const PENDING = 'pending';
    public const CONFIRMED = 'confirmed';
    public const REVERSED = 'reversed';
    public const PAID = 'paid';

    public function __construct(private string $value) {}

    public static function confirmed(): self { return new self(self::CONFIRMED); }
    public static function reversed(): self { return new self(self::REVERSED); }
    public static function paid(): self { return new self(self::PAID); }
    public static function tracked(): self { return new self(self::TRACKED); }
    public static function pending(): self { return new self(self::PENDING); }

    public function canTransitionTo(self $next): bool
    {
        return match ($this) {
            self::TRACKED => in_array($next, [self::PENDING, self::REVERSED], true),
            self::PENDING => in_array($next, [self::CONFIRMED, self::REVERSED], true),
            self::CONFIRMED => in_array($next, [self::REVERSED, self::PAID], true),
            self::REVERSED => false,
            self::PAID => false,
            default => false,
        };
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