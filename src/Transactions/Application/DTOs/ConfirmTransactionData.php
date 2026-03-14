<?php

final class ConfirmTransactionData
{
    public function __construct(
        public readonly string $transactionId,
        public readonly DateTimeImmutable $confirmedAt,
    ) {}
}