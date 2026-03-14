<?php

final class TransactionReversalPolicy
{
    public function decide(Transaction $transaction): ReversalDecision
    {
        $status = $transaction->status()->value();
        $amount = $transaction->cashbackAmount()->amountInMinor();

        return match ($status) {
            'tracked', 'pending' => ReversalDecision::allow('pending', $amount),
            'confirmed' => ReversalDecision::allow('available', $amount),
            'paid' => ReversalDecision::deny('Paid transactions require manual recovery flow.'),
            'reversed' => ReversalDecision::deny('Transaction is already reversed.'),
            default => ReversalDecision::deny('Unsupported transaction state for reversal.'),
        };
    }
}