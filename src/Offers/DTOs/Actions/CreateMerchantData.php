<?php

namespace Cashback\Offers\DTOs\Actions;

use Cashback\Support\ActionData;
use Illuminate\Validation\Rule;

class CreateMerchantData extends ActionData
{
    public function __construct(
        public string $name,
        public ?string $website_url,
        public ?string $logo_url,
        public ?string $status = 'active',
    ) {}

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'url'],
            'logo_url' => ['nullable', 'url'],
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
        ];
    }
}
