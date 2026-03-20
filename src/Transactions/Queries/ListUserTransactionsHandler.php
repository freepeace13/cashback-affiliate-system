<?php

namespace Cashback\Transactions\Queries;

use Cashback\Transactions\Contracts\Queries\ListUserTransactionsQueryHandler;
use Cashback\Transactions\DTOs\Queries\ListUserTransactionsQuery;
use Cashback\Transactions\DTOs\TransactionData;
use Cashback\Transactions\Entities\Transaction;
use Cashback\Transactions\Mappers\TransactionEntityMapper;
use Cashback\Transactions\Repositories\TransactionRepository;

class ListUserTransactionsHandler implements ListUserTransactionsQueryHandler
{
    public function __construct(
        private TransactionRepository $transactions,
        private TransactionEntityMapper $transactionEntityMapper,
    ) {}

    public function handle(ListUserTransactionsQuery $query): array
    {
        $transactions = $this->transactions->listByUserId($query->userId);

        return array_map(
            fn (Transaction $transaction): TransactionData => $this->transactionEntityMapper->mapEntityToData($transaction),
            $transactions
        );
    }
}
