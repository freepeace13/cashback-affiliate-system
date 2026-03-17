<?php

namespace Cashback\Transactions\Events;

use Cashback\Transactions\ValueObjects\TransactionID;
use DateTimeImmutable;

final class TransactionConfirmed
{
    public function __construct(
        public readonly TransactionID $transactionId,
        public readonly DateTimeImmutable $confirmedAt,
    ) {}
}