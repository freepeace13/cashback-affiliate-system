<?php

final class DefaultTransactionReversibleSpecification implements TransactionReversibleSpecification
{
    public function isSatisfiedBy(Transaction $transaction): bool
    {
        return in_array(
            $transaction->status()->value(),
            ['pending', 'confirmed'],
            true
        );
    }
}