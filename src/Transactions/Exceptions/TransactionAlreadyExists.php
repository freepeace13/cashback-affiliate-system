<?php

namespace Cashback\Transactions\Exceptions;

use Exception;

final class TransactionAlreadyExists extends Exception
{
    public function __construct()
    {
        parent::__construct('Transaction already exists');
    }
}