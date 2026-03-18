<?php

namespace Cashback\Ledger\Enums;

enum LedgerBucket: string
{
    case PENDING = 'pending';
    case AVAILABLE = 'available';
    case RESERVED = 'reserved';
    case PAID = 'paid';
}
