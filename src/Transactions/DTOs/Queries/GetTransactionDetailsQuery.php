<?php

namespace Cashback\Transactions\DTOs\Queries;

class GetTransactionDetailsQuery
{
    public function __construct(
        public readonly string $transactionId,
    ) {}
}
