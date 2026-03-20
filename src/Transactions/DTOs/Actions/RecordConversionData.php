<?php

namespace Cashback\Transactions\DTOs\Actions;

use Cashback\Support\ActionData;
use Cashback\Support\Currency;
use Cashback\Support\Money;
use Cashback\Transactions\Enums\TransactionStatus;
use DateTimeImmutable;

class RecordConversionData extends ActionData
{
    public function __construct(
        public ?string $clickRef,
        public Currency $currency,
        public Money $orderAmountInMinor,
        public Money $commissionAmount,
        public Money $cashbackAmount,
        public TransactionStatus $status,
        public DateTimeImmutable $occurredAt,
    ) {}

    public function rules(): array
    {
        return [
            'clickRef' => ['nullable', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:255'],
            'orderAmountInMinor' => ['required', 'numeric', 'min:0'],
            'commissionAmount' => ['required', 'numeric', 'min:0'],
            'cashbackAmount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:255'],
            'occurredAt' => ['required', 'datetime'],
        ];
    }
}
