<?php

namespace Cashback\Transactions\Actions;

use Cashback\Transactions\Repositories\TransactionRepository;
use Cashback\Transactions\Contracts\Actions\ReversesTransactionAction as ReversesTransactionActionContract;
use Cashback\Transactions\DTOs\Actions\ReverseTransactionData;
use Cashback\Transactions\DTOs\TransactionData;
// use Cashback\Transactions\Policies\TransactionReversalPolicy;
use Cashback\Contracts\LedgerPostingContract;
use RuntimeException;

class ReverseTransactionAction implements ReversesTransactionActionContract
{
    public function __construct(
        private TransactionRepository $transactions,
        // private TransactionReversalPolicy $reversalPolicy,
        private LedgerPostingContract $ledgerPosting,
    ) {}

    public function reverse(ReverseTransactionData $data): TransactionData
    {
        // $transaction = $this->transactions->find($transactionId);

        // if (! $transaction) {
        //     throw TransactionNotFound::withId($transactionId);
        // }

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
