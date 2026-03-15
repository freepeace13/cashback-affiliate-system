<?php

namespace CashbackAffiliateSystem\Transactions\Actions;

use CashbackAffiliateSystem\Transactions\Contracts\TransactionRepository;
use CashbackAffiliateSystem\Transactions\DTOs\RecordConversionData;
use CashbackAffiliateSystem\Transactions\Entities\Transaction;
use CashbackAffiliateSystem\Transactions\Factories\TransactionFactory;

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