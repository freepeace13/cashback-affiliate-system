<?php

namespace Cashback\Transactions\DTOs;

use Cashback\Transactions\ValueObjects\ExternalTransactionID;
use Cashback\Transactions\ValueObjects\TransactionStatus;
use Cashback\Shared\ValueObjects\Currency;
use Cashback\Shared\ValueObjects\Money;
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