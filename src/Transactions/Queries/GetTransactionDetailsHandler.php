<?php

namespace CashbackAffiliateSystem\Transactions\Queries;

use CashbackAffiliateSystem\Transactions\Repositories\TransactionRepository;
use CashbackAffiliateSystem\Transactions\DTOs\TransactionData;
use CashbackAffiliateSystem\Transactions\ValueObjects\TransactionID;

class GetTransactionDetailsHandler
{
    public function __construct(
        private TransactionRepository $transactions,
    ) {}

    public function handle(GetTransactionDetailsQuery $query): ?TransactionData
    {
        $transaction = $this->transactions->find(new TransactionID($query->transactionId));
        
        if (! $transaction) {
            return null;
        }

        return new TransactionData(
            id: $transaction->id()->value(),
            status: $transaction->status()->value(),
        );
    }
}