<?php

namespace Cashback\Transactions;

enum TransactionStatus: string
{
    case TRACKED = 'tracked';
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case REVERSED = 'reversed';
    case PAID = 'paid';

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
}
