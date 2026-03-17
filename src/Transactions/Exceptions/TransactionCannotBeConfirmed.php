<?php

namespace Cashback\Transactions\Exceptions;

use RuntimeException;

final class TransactionCannotBeConfirmed extends RuntimeException
{
    public static function fromStatus(string $status): self
    {
        return new self("Transaction cannot be confirmed from status [{$status}].");
    }
}