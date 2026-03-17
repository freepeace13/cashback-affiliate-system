<?php

namespace Cashback\Ledger\Entities;

use Cashback\Ledger\ValueObjects\LedgerBucket;
use Cashback\Ledger\Enums\Direction;
use Cashback\Shared\ValueObjects\Money;
use Cashback\Shared\ValueObjects\Currency;
use Cashback\Ledger\ValueObjects\LedgerEntryID;

class LedgerEntry
{
    public function __construct(
        private LedgerEntryID $id,
        private string $userId,
        private ?string $transactionId,
        private ?string $payoutRequestId,
        private string $entryType,
        private LedgerBucket $bucket,
        private Direction $direction,
        private Money $amount,
        private Currency $currency,
        private string $description,
        private ?string $referenceType,
        private ?string $referenceId,
    ) {}

    public function id(): LedgerEntryID
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

    public function bucket(): Bucket
    {
        return $this->bucket;
    }

    public function direction(): Direction
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

    public function description(): string
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