<?php

namespace Cashback\Offers\DTOs\Actions;

use Cashback\Support\ActionData;

final class GenerateOfferClickUrlData extends ActionData
{
    public function __construct(
        public string $baseUrl,
        public string $path,
        public string $userId,
        public string $offerId,
        public string $destinationUrl,
    ) {}

    public function rules(): array
    {
        return [
            'baseUrl' => ['required', 'url'],
            'path' => ['required', 'string'],
            'userId' => ['required', 'string', 'max:255'],
            'offerId' => ['required', 'string', 'max:255'],
            'destinationUrl' => ['required', 'url'],
        ];
    }
}
