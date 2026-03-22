<?php

namespace Cashback\Offers\DTOs\Actions;

use Cashback\Support\ActionData;
use Illuminate\Validation\Rule;

class UpdateOfferData extends ActionData
{
    public function __construct(
        public int $id,
        public int $merchantId,
        public int $affiliateNetworkId,
        public string $title,
        public ?string $description,
        public string $trackingUrl,
        public string $cashbackType,
        public string $cashbackValue,
        public string $currency,
        public string $status,
        public ?string $startsAt = null,
        public ?string $endsAt = null,
    ) {}

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
            'merchantId' => ['required', 'integer', 'min:1'],
            'affiliateNetworkId' => ['required', 'integer', 'min:1'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'trackingUrl' => ['required', 'url'],
            'cashbackType' => ['required', 'string', 'max:255'],
            'cashbackValue' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', Rule::in(['active', 'inactive'])],
            'startsAt' => ['nullable', 'string', 'date'],
            'endsAt' => ['nullable', 'string', 'date'],
        ];
    }
}
