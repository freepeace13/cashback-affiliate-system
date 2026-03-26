<?php

namespace Cashback\Offers\DTOs\Actions;

use Cashback\Support\ActionData;
use Illuminate\Validation\Rule;

class UpdateOfferData extends ActionData
{
    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $trackingUrl,
        public ?string $cashbackType,
        public ?string $cashbackValue,
    ) {}

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'trackingUrl' => ['required', 'url'],
            'cashbackType' => ['required', 'string', 'max:255'],
            'cashbackValue' => ['required', 'numeric', 'min:0'],
        ];
    }
}
