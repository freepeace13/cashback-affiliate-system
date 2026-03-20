<?php

namespace Cashback\Offers\DTOs\Actions;

use Cashback\Support\ActionData;
use Illuminate\Validation\Rule;

class UpdateMerchantData extends ActionData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public ?string $website_url,
        public ?string $logo_url,
        public ?string $status = 'active',
    ) {}

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'url'],
            'logo_url' => ['nullable', 'url'],
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
        ];
    }
}
