<?php

final class TransactionConfirmed
{
    public function __construct(
        public readonly string $transactionId,
        public readonly DateTimeImmutable $confirmedAt,
    ) {}
}