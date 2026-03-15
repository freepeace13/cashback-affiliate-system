<?php

namespace CashbackAffiliateSystem\Transactions\Queries;

class GetTransactionDetailsQuery
{
    public function __construct(
        public readonly string $transactionId,
    ) {}
}