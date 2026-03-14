<?php

final class RecordConversionAction
{
    public function __construct(
        private TransactionRepository $transactions,
        private TransactionFactory $factory,
    ) {}

    public function execute(RecordConversionData $data): Transaction
    {
        $existing = $this->transactions->findByExternalTransactionId(
            new ExternalTransactionId($data->externalTransactionId)
        );

        if ($existing) {
            return $existing;
        }

        $transaction = $this->factory->fromConversionData($data);

        $this->transactions->save($transaction);

        return $transaction;
    }
}