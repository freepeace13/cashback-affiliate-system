<?php

namespace CashbackAffiliateSystem\Transactions\Events;

use CashbackAffiliateSystem\Transactions\ValueObjects\TransactionID;
use DateTimeImmutable;

final class TransactionConfirmed
{
    public function __construct(
        public readonly TransactionID $transactionId,
        public readonly DateTimeImmutable $confirmedAt,
    ) {}
}