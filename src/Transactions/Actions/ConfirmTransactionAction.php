<?php

namespace Cashback\Transactions\Actions;

use Cashback\Transactions\Repositories\TransactionRepository;
use Cashback\Transactions\Contracts\Actions\ConfirmsTransactionAction as ConfirmsTransactionActionContract;
use Cashback\Transactions\DTOs\Actions\ConfirmTransactionData;
use Cashback\Transactions\DTOs\TransactionData;
use Cashback\Transactions\Exceptions\TransactionNotFound;
use Cashback\Transactions\Mappers\TransactionEntityMapper;

class ConfirmTransactionAction implements ConfirmsTransactionActionContract
{
    public function __construct(
        private TransactionRepository $transactions,
        private TransactionEntityMapper $transactionEntityMapper,
    ) {}

    public function confirm(ConfirmTransactionData $data): TransactionData
    {
        $transaction = $this->transactions->find($data->transactionId);

        if (! $transaction) {
            throw TransactionNotFound::withId($data->transactionId);
        }

        // if (! $this->confirmableSpecification->isSatisfiedBy($transaction)) {
        //     throw TransactionCannotBeConfirmed::fromStatus(
        //         $transaction->status()->value()
        //     );
        // }

        $transaction->confirm($data->confirmedAt);

        return $this->transactionEntityMapper->mapEntityToData($transaction);
    }
}
