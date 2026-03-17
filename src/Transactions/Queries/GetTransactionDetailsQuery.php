<?php

namespace Cashback\Transactions\Queries;

class GetTransactionDetailsQuery
{
    public function __construct(
        public readonly string $transactionId,
    ) {}
}