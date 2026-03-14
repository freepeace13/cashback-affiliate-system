<?php

declare(strict_types=1);

final class Transaction
{
    /** @var array<object> */
    private array $recordedEvents = [];

    public function __construct(
        private TransactionId $id,
        private TransactionStatus $status,
        private Money $cashbackAmount,
        private ?DateTimeImmutable $confirmedAt = null,
        private ?DateTimeImmutable $reversedAt = null,
    ) {}

    public function id(): TransactionId
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

    public function confirm(DateTimeImmutable $confirmedAt): void
    {
        $currentStatus = $this->status->value();

        if (! in_array($currentStatus, ['tracked', 'pending'], true)) {
            throw TransactionCannotBeConfirmed::fromStatus($currentStatus);
        }

        $this->status = TransactionStatus::confirmed();
        $this->confirmedAt = $confirmedAt;

        $this->recordThat(
            new TransactionConfirmed(
                transactionId: $this->id->value(),
                confirmedAt: $confirmedAt,
            )
        );
    }

    /**
     * @return array<object>
     */
    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];

        return $events;
    }

    private function recordThat(object $event): void
    {
        $this->recordedEvents[] = $event;
    }
}