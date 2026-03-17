<?php

namespace Cashback\Transactions\Exceptions;

use RuntimeException;

final class TransactionNotFound extends RuntimeException
{
    public static function withId(string $transactionId): self
    {
        return new self("Transaction not found: {$transactionId}");
    }
}