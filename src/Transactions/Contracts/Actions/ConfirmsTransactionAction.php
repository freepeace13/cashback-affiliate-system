<?php

namespace Cashback\Transactions\Contracts\Actions;

use Cashback\Transactions\DTOs\Actions\ConfirmTransactionData;
use Cashback\Transactions\DTOs\TransactionData;

interface ConfirmsTransactionAction
{
    public function confirm(ConfirmTransactionData $data): TransactionData;
}
