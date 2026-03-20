<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\CreatesMerchantAction as CreatesMerchantActionContract;
use Cashback\Offers\DTOs\Actions\CreateMerchantData;
use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\Mappers\MerchantEntityMapper;
use Cashback\Offers\Repositories\MerchantRepository;
use Illuminate\Support\Str;

class CreateMerchantAction implements CreatesMerchantActionContract
{
    public function __construct(
        private MerchantRepository $merchants,
        private MerchantEntityMapper $merchantEntityMapper,
    ) {}

    public function create(CreateMerchantData $data): MerchantData
    {
        $validated = $data->validate();

        $created = $this->merchants->create(
            new Merchant(
                id: -1,
                name: $validated['name'],
                slug: Str::slug($validated['name']),
                status: $validated['status'],
                websiteUrl: $validated['website_url'] ?? '',
                logoUrl: $validated['logo_url'] ?? '',
            )
        );

        return $this->merchantEntityMapper->mapEntityToData($created);
    }
}
