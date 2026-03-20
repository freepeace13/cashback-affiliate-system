<?php

namespace Cashback\Transactions\Contracts\Queries;

use Cashback\Transactions\DTOs\Queries\ListUserTransactionsQuery;
use Cashback\Transactions\DTOs\TransactionData;

interface ListUserTransactionsQueryHandler
{
    /**
     * @return TransactionData[]
     */
    public function handle(ListUserTransactionsQuery $query): array;
}
