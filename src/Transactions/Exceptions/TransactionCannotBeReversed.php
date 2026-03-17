<?php

namespace Cashback\Transactions\Exceptions;

use RuntimeException;

final class TransactionCannotBeReversed extends RuntimeException
{
    public static function fromStatus(string $status): self
    {
        return new self("Transaction cannot be reversed from status [{$status}].");
    }
}