<?php

final class UniqueExternalTransactionSpecification
{
    public function __construct(
        private TransactionRepository $transactions
    ) {}

    public function isSatisfiedBy(ExternalTransactionId $externalTransactionId): bool
    {
        return $this->transactions->findByExternalTransactionId($externalTransactionId) === null;
    }
}