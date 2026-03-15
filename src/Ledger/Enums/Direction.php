<?php

namespace CashbackAffiliateSystem\Ledger\Enums;

enum Direction: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';
}