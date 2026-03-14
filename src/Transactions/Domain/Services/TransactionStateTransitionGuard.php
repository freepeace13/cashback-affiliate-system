<?php

final class TransactionStateTransitionGuard
{
    public function ensureCanConfirm(Transaction $transaction): void
    {
        if (! $transaction->status()->canTransitionTo(TransactionStatus::confirmed())) {
            throw new TransactionCannotBeConfirmed();
        }
    }

    public function ensureCanReverse(Transaction $transaction): void
    {
        if (! $transaction->status()->canTransitionTo(TransactionStatus::reversed())) {
            throw new TransactionCannotBeReversed();
        }
    }
}