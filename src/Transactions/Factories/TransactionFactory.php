<?php

namespace CashbackAffiliateSystem\Transactions\Factories;

use CashbackAffiliateSystem\Transactions\DTOs\RecordConversionData;
use CashbackAffiliateSystem\Transactions\Entities\Transaction;

interface TransactionFactory
{
    public function fromConversionData(RecordConversionData $data): Transaction;
}