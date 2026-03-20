<?php

namespace Cashback\Transactions\Contracts\Actions;

use Cashback\Transactions\DTOs\Actions\RecordConversionData;
use Cashback\Transactions\DTOs\TransactionData;

interface RecordsConversionAction
{
    public function record(RecordConversionData $data): TransactionData;
}
