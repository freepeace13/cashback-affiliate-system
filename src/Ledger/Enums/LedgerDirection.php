<?php

namespace Cashback\Ledger\Enums;

enum LedgerDirection: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';
}
