<?php

namespace Cashback\Transactions\DTOs;

use Cashback\Support\Currency;
use Cashback\Support\Money;
use Cashback\Transactions\TransactionStatus;
use Cashback\Transactions\ValueObjects\ExternalTransactionID;
use DateTimeImmutable;

final class RecordConversionData
{
    public function __construct(
        public readonly ExternalTransactionID $externalTransactionId,
        public readonly ?string $clickRef,
        public readonly Currency $currency,
        public readonly Money $orderAmountInMinor,
        public readonly Money $commissionAmount,
        public readonly Money $cashbackAmount,
        public readonly TransactionStatus $status,
        public readonly DateTimeImmutable $occurredAt,
    ) {}
}