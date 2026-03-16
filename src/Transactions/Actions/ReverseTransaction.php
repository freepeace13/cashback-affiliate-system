<?php

namespace CashbackAffiliateSystem\Transactions\Actions;

use CashbackAffiliateSystem\Transactions\Repositories\TransactionRepository;
use CashbackAffiliateSystem\Transactions\ValueObjects\TransactionID;
use CashbackAffiliateSystem\Transactions\Exceptions\TransactionNotFound;
// use CashbackAffiliateSystem\Transactions\Policies\TransactionReversalPolicy;
use CashbackAffiliateSystem\Shared\Repositories\LedgerPostingContract;
use RuntimeException;

class ReverseTransaction
{
    public function __construct(
        private TransactionRepository $transactions,
        // private TransactionReversalPolicy $reversalPolicy,
        private LedgerPostingContract $ledgerPosting,
    ) {}

    public function execute(TransactionID $transactionId): void
    {
        $transaction = $this->transactions->find($transactionId);

        if (! $transaction) {
            throw TransactionNotFound::withId($transactionId);
        }

        // $decision = $this->reversalPolicy->decide($transaction);

        // if (! $decision->allowed) {
        //     throw new RuntimeException($decision->reason ?? 'Transaction cannot be reversed.');
        // }

        // Here you now know the expected financial effect:
        // $decision->ledgerBucketToDebit
        // $decision->amountInMinor

        // Example:
        // 1. mark domain transaction reversed
        // 2. post ledger debit on the bucket decided by policy
        // 3. persist everything in a DB transaction

        // pseudo:
        // $transaction->reverse(new DateTimeImmutable());
        // $this->ledgerPosting->reverseConfirmedCashback($decision->ledgerBucketToDebit, $decision->amountInMinor);
        // $this->transactions->save($transaction);
    }
}