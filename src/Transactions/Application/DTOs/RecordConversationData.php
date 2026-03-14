<?php

final class RecordConversionData
{
    public function __construct(
        public readonly string $externalTransactionId,
        public readonly ?string $clickRef,
        public readonly string $currency,
        public readonly int $orderAmountInMinor,
        public readonly int $commissionAmountInMinor,
        public readonly int $cashbackAmountInMinor,
        public readonly string $status,
        public readonly \DateTimeImmutable $occurredAt,
    ) {}
}