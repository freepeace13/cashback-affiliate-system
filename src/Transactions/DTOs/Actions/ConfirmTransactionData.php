<?php

namespace Cashback\Transactions\DTOs\Actions;

use Cashback\Support\ActionData;
use DateTimeImmutable;

class ConfirmTransactionData extends ActionData
{
    public function __construct(
        public string $transactionId,
        public DateTimeImmutable $confirmedAt,
    ) {}

    public function rules(): array
    {
        return [
            'transactionId' => ['required', 'string', 'max:255'],
            'confirmedAt' => ['required', 'datetime'],
        ];
    }
}
