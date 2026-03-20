<?php

namespace Cashback\Transactions\Queries;

use Cashback\Transactions\Contracts\Queries\GetTransactionDetailsQueryHandler;
use Cashback\Transactions\DTOs\Queries\GetTransactionDetailsQuery;
use Cashback\Transactions\DTOs\TransactionData;
use Cashback\Transactions\Mappers\TransactionEntityMapper;
use Cashback\Transactions\Repositories\TransactionRepository;
use Cashback\Transactions\ValueObjects\TransactionID;

class GetTransactionDetailsHandler implements GetTransactionDetailsQueryHandler
{
    public function __construct(
        private TransactionRepository $transactions,
        private TransactionEntityMapper $transactionEntityMapper,
    ) {}

    public function handle(GetTransactionDetailsQuery $query): ?TransactionData
    {
        $transaction = $this->transactions->find(new TransactionID($query->transactionId));

        if (! $transaction) {
            return null;
        }

        return $this->transactionEntityMapper->mapEntityToData($transaction);
    }
}
