<?php

namespace Cashback\Transactions\Actions;

use Cashback\Transactions\Repositories\TransactionRepository;
use Cashback\Transactions\DTOs\RecordConversionData;
use Cashback\Transactions\Contracts\Actions\RecordsConversionAction as RecordsConversionActionContract;
use Cashback\Transactions\DTOs\TransactionData;
use Cashback\Transactions\Mappers\TransactionEntityMapper;

final class RecordConversionAction implements RecordsConversionActionContract
{
    public function __construct(
        private TransactionRepository $transactions,
        private TransactionEntityMapper $transactionEntityMapper,
    ) {}

    public function record(RecordConversionData $data): TransactionData
    {
        //
    }
}
