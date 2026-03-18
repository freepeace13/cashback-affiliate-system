<?php

namespace Cashback\Payouts\Entities;

use Cashback\Payouts\ValueObjects\PayoutStatus;
use DateTimeImmutable;
use RuntimeException;

final class PayoutRequest
{
    public function __construct(
        private int $id,
        private string $uuid,
        private int $userId,
        private PayoutStatus $status,
        private int $amount,
        private string $currency,
        private string $method,
        private ?array $destinationDetails,
        private DateTimeImmutable $requestedAt,
        private ?DateTimeImmutable $approvedAt = null,
        private ?DateTimeImmutable $processedAt = null,
        private ?DateTimeImmutable $failedAt = null,
        private ?string $failureReason = null,
        private ?string $notes = null,
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function status(): PayoutStatus
    {
        return $this->status;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function destinationDetails(): ?array
    {
        return $this->destinationDetails;
    }

    public function requestedAt(): DateTimeImmutable
    {
        return $this->requestedAt;
    }

    public function approvedAt(): ?DateTimeImmutable
    {
        return $this->approvedAt;
    }

    public function processedAt(): ?DateTimeImmutable
    {
        return $this->processedAt;
    }

    public function failedAt(): ?DateTimeImmutable
    {
        return $this->failedAt;
    }

    public function failureReason(): ?string
    {
        return $this->failureReason;
    }

    public function notes(): ?string
    {
        return $this->notes;
    }

    public function approve(DateTimeImmutable $at): void
    {
        if ($this->status->value() !== PayoutStatus::REQUESTED) {
            throw new RuntimeException(
                "Payout cannot be approved from status [{$this->status->value()}]"
            );
        }
        $this->status = PayoutStatus::approved();
        $this->approvedAt = $at;
    }

    public function markProcessing(DateTimeImmutable $at): void
    {
        if ($this->status->value() !== PayoutStatus::APPROVED) {
            throw new RuntimeException(
                "Payout cannot be marked processing from status [{$this->status->value()}]"
            );
        }
        $this->status = PayoutStatus::processing();
        $this->processedAt = $at;
    }

    public function complete(DateTimeImmutable $at): void
    {
        if ($this->status->value() !== PayoutStatus::PROCESSING) {
            throw new RuntimeException(
                "Payout cannot be completed from status [{$this->status->value()}]"
            );
        }
        $this->status = PayoutStatus::paid();
        $this->processedAt = $at;
    }

    public function fail(DateTimeImmutable $at, string $reason): void
    {
        $this->status = PayoutStatus::failed();
        $this->failedAt = $at;
        $this->failureReason = $reason;
    }
}
