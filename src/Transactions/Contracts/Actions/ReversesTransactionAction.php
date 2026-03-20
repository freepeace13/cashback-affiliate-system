<?php

namespace Cashback\Transactions\Contracts\Actions;

use Cashback\Transactions\DTOs\Actions\ReverseTransactionData;
use Cashback\Transactions\DTOs\TransactionData;

interface ReversesTransactionAction
{
    public function reverse(ReverseTransactionData $data): TransactionData;
}
