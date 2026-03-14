<?php

final class ConfirmTransactionAction
{
    public function __construct(
        private TransactionRepository $transactions,
        private TransactionConfirmableSpecification $confirmableSpecification,
    ) {}

    public function execute(ConfirmTransactionData $data): void
    {
        $transaction = $this->transactions->findById(
            new TransactionId($data->transactionId)
        );

        if (! $transaction) {
            throw TransactionNotFound::withId($data->transactionId);
        }

        if (! $this->confirmableSpecification->isSatisfiedBy($transaction)) {
            throw TransactionCannotBeConfirmed::fromStatus(
                $transaction->status()->value()
            );
        }

        $transaction->confirm($data->confirmedAt);

        $this->transactions->save($transaction);

        foreach ($transaction->releaseEvents() as $event) {
            // dispatch domain event later through your bus/event dispatcher
            // e.g. $this->eventBus->dispatch($event);
        }
    }
}