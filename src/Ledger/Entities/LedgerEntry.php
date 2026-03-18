<?php

namespace Cashback\Ledger\Entities;

use Cashback\Ledger\Enums\LedgerDirection;
use Cashback\Ledger\Enums\LedgerBucket;
use Cashback\Support\Currency;
use Cashback\Support\Money;

class LedgerEntry
{
    public function __construct(
        private int $id,
        private string $userId,
        private ?string $transactionId,
        private ?string $payoutRequestId,
        private string $entryType,
        private LedgerBucket $bucket,
        private LedgerDirection $direction,
        private Money $amount,
        private Currency $currency,
        private ?string $description = null,
        private ?string $referenceType,
        private ?string $referenceId,
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function transactionId(): ?string
    {
        return $this->transactionId;
    }

    public function payoutRequestId(): ?string
    {
        return $this->payoutRequestId;
    }

    public function entryType(): string
    {
        return $this->entryType;
    }

    public function bucket(): LedgerBucket
    {
        return $this->bucket;
    }

    public function direction(): LedgerDirection
    {
        return $this->direction;
    }

    public function amount(): Money
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function referenceType(): ?string
    {
        return $this->referenceType;
    }

    public function referenceId(): ?string
    {
        return $this->referenceId;
    }
}
