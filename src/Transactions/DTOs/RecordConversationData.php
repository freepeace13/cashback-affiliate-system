<?php

namespace CashbackAffiliateSystem\Transactions\DTOs;

use CashbackAffiliateSystem\Transactions\ValueObjects\ExternalTransactionID;
use CashbackAffiliateSystem\Transactions\ValueObjects\TransactionStatus;
use CashbackAffiliateSystem\Shared\ValueObjects\Currency;
use CashbackAffiliateSystem\Shared\ValueObjects\Money;
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