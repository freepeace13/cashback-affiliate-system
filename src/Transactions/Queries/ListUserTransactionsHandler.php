<?php

namespace CashbackAffiliateSystem\Transactions\Queries;

use CashbackAffiliateSystem\Transactions\Repositories\TransactionRepository;
use CashbackAffiliateSystem\Transactions\DTOs\TransactionData;
use CashbackAffiliateSystem\Transactions\Entities\Transaction;

class ListUserTransactionsHandler
{
    public function __construct(
        private TransactionRepository $transactions,
    ) {}

    public function handle(ListUserTransactionsQuery $query): array
    {
        $transactions = $this->transactions->listByUserId($query->userId);

        return array_map(fn (Transaction $transaction): TransactionData => new TransactionData(
            id: $transaction->id()->value(),
            status: $transaction->status()->value(),
        ), $transactions);
    }
}