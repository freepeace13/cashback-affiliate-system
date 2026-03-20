<?php

namespace Cashback\Transactions\Entities;

use Cashback\Support\Money;
use Cashback\Transactions\Events\TransactionConfirmed;
use Cashback\Transactions\Exceptions\TransactionCannotBeConfirmed;
use Cashback\Transactions\Exceptions\TransactionCannotBeReversed;
use Cashback\Transactions\Enums\TransactionStatus;
use Cashback\Transactions\ValueObjects\TransactionID;
use DateTimeImmutable;

final class Transaction
{
    /** @var object[] */
    private array $domainEvents = [];

    public function __construct(
        private int $id,
        private ?int $userId,
        private TransactionStatus $status,
        private Money $cashbackAmount,
        private ?DateTimeImmutable $confirmedAt = null,
        private ?DateTimeImmutable $reversedAt = null,
        private ?DateTimeImmutable $paidAt = null,
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function status(): TransactionStatus
    {
        return $this->status;
    }

    public function cashbackAmount(): Money
    {
        return $this->cashbackAmount;
    }

    public function confirmedAt(): ?DateTimeImmutable
    {
        return $this->confirmedAt;
    }

    public function reversedAt(): ?DateTimeImmutable
    {
        return $this->reversedAt;
    }

    public function paidAt(): ?DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function userId(): ?int
    {
        return $this->userId;
    }

    public function currency(): string
    {
        return $this->cashbackAmount->currency()->value();
    }

    public function confirm(DateTimeImmutable $confirmedAt): self
    {
        if (in_array($this->status, [TransactionStatus::TRACKED, TransactionStatus::PENDING], true)) {
            $this->status = TransactionStatus::CONFIRMED;
            $this->confirmedAt = $confirmedAt;
            $this->recordEvent(new TransactionConfirmed(
                new TransactionID((string) $this->id),
                $confirmedAt
            ));

            return $this;
        }

        throw TransactionCannotBeConfirmed::fromStatus($this->status->value);
    }

    public function reverse(DateTimeImmutable $reversedAt): void
    {
        if (! $this->status->canTransitionTo(TransactionStatus::REVERSED)) {
            throw TransactionCannotBeReversed::fromStatus($this->status->value);
        }
        $this->status = TransactionStatus::REVERSED;
        $this->reversedAt = $reversedAt;
    }

    public function markPaid(DateTimeImmutable $paidAt): void
    {
        if (! $this->status->canTransitionTo(TransactionStatus::PAID)) {
            throw new \RuntimeException(
                "Transaction cannot be marked paid from status [{$this->status->value}]"
            );
        }
        $this->status = TransactionStatus::PAID;
        $this->paidAt = $paidAt;
    }

    /**
     * @return object[]
     */
    public function releaseEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];

        return $events;
    }

    private function recordEvent(object $event): void
    {
        $this->domainEvents[] = $event;
    }
}
