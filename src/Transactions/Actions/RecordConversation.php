<?php

namespace Cashback\Transactions\Actions;

use Cashback\Transactions\Repositories\TransactionRepository;
use Cashback\Transactions\DTOs\RecordConversionData;
use Cashback\Transactions\Entities\Transaction;
use Cashback\Transactions\Factories\TransactionFactory;

final class RecordConversion
{
    public function __construct(
        private TransactionRepository $transactions,
        private TransactionFactory $factory,
    ) {}

    public function execute(RecordConversionData $data): Transaction
    {
        $existing = $this->transactions->findByExternalTransactionId($data->externalTransactionId);

        if ($existing) {
            return $existing;
        }

        $this->transactions->save(
            $transaction = $this->factory->fromConversionData($data)
        );

        return $transaction;
    }
}