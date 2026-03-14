<?php

final class DefaultTransactionConfirmableSpecification implements TransactionConfirmableSpecification
{
    public function isSatisfiedBy(Transaction $transaction): bool
    {
        return in_array(
            $transaction->status()->value(),
            ['tracked', 'pending'],
            true
        );
    }
}