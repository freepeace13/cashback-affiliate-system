<?php

namespace Cashback\Offers\DTOs\Actions;

use Cashback\Support\ActionData;

class CreateOfferData extends ActionData
{
    public function __construct(
        public string $title,
        public ?string $description,
        public string $trackingUrl,
        public string $cashbackType,
        public string $cashbackValue,
        public string $currency,
        public string $status,
        public int $merchantId,
        public int $affiliateNetworkId,
    ) {}

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'trackingUrl' => ['required', 'url'],
            'cashbackType' => ['required', 'string', 'max:255'],
            'cashbackValue' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'merchantId' => ['required', 'integer', 'min:1'],
            'affiliateNetworkId' => ['required', 'integer', 'min:1'],
        ];
    }
}
