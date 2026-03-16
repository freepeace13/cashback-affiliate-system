<?php

namespace CashbackAffiliateSystem\Offers\Actions;

use CashbackAffiliateSystem\Offers\Entities\Merchant;
use CashbackAffiliateSystem\Offers\Repositories\MerchantRepository;
use CashbackAffiliateSystem\Offers\DTOs\MerchantData;
use CashbackAffiliateSystem\Offers\Contracts\CreatesMerchantAction;

class CreateMerchant implements CreatesMerchantAction
{
    public function __construct(
        private MerchantRepository $merchantRepository
    ) {}

    public function create(MerchantData $data): MerchantData
    {
        $merchant = new Merchant(
            id: $data->slug,
            name: $data->name,
        );

        $this->merchantRepository->create($merchant);

        // Return DTO back to the caller so controllers/views don't depend on entities.
        return $data;
    }
}