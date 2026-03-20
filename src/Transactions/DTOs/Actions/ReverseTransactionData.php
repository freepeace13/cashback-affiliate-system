<?php

namespace Cashback\Transactions\DTOs\Actions;

use Cashback\Support\ActionData;

class ReverseTransactionData extends ActionData
{
    public function __construct(
        public string $transactionId,
    ) {}

    public function rules(): array
    {
        return [
            'transactionId' => ['required', 'string', 'max:255'],
        ];
    }
}
