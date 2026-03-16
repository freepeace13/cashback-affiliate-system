<?php

namespace CashbackAffiliateSystem\Offers\Queries\ListMerchants;

use CashbackAffiliateSystem\Offers\DTOs\MerchantData;
use CashbackAffiliateSystem\Offers\Entities\Merchant;
use CashbackAffiliateSystem\Offers\Repositories\MerchantRepository;

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

