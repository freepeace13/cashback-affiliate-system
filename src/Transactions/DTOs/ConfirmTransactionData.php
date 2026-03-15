<?php

namespace CashbackAffiliateSystem\Transactions\DTOs;

use CashbackAffiliateSystem\Transactions\ValueObjects\TransactionID;
use DateTimeImmutable;

final class ConfirmTransactionData
{
    public function __construct(
        public readonly TransactionID $transactionId,
        public readonly DateTimeImmutable $confirmedAt,
    ) {}
}