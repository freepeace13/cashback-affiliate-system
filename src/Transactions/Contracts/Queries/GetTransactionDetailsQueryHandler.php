<?php

namespace Cashback\Transactions\Contracts\Queries;

use Cashback\Transactions\DTOs\Queries\GetTransactionDetailsQuery;
use Cashback\Transactions\DTOs\TransactionData;

interface GetTransactionDetailsQueryHandler
{
    public function handle(GetTransactionDetailsQuery $query): ?TransactionData;
}
