<?php

final class GetTransactionDetailsHandler
{
    public function __construct(
        private TransactionReadRepository $readRepository,
    ) {}

    public function handle(GetTransactionDetailsQuery $query): ?TransactionData
    {
        return $this->readRepository->findDataById($query->transactionId);
    }
}