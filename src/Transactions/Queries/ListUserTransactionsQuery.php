<?php

namespace Cashback\Transactions\Queries;

class ListUserTransactionsQuery
{
    public function __construct(
        public readonly string $userId,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
    ) {}
}