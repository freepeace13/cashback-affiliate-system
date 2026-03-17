<?php

namespace Cashback\Ledger\Enums;

enum Direction: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';
}