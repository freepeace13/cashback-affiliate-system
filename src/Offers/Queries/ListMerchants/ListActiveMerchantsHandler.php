<?php

namespace Cashback\Offers\Queries\ListMerchants;

use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\Repositories\MerchantRepository;

class ListActiveMerchantsHandler
{
    public function __construct(
        private MerchantRepository $merchantRepository,
    ) {}

    /**
     * @return MerchantData[]
     */
    public function handle(ListActiveMerchantsQuery $query): array
    {
        $merchants = $this->merchantRepository->listActiveMerchants();

        return array_map(
            fn (Merchant $merchant): MerchantData => new MerchantData(
                name: $merchant->name,
                slug: $merchant->id,
                websiteUrl: '',
                logoUrl: '',
                status: '',
                createdAt: '',
                updatedAt: '',
            ),
            $merchants
        );
    }
}

