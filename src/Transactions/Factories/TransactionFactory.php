<?php

namespace Cashback\Transactions\Factories;

use Cashback\Transactions\DTOs\RecordConversionData;
use Cashback\Transactions\Entities\Transaction;

interface TransactionFactory
{
    public function fromConversionData(RecordConversionData $data): Transaction;
}