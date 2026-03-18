<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\Repositories\MerchantRepository;
use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\Contracts\UpdatesMerchantAction;

class UpdateMerchant implements UpdatesMerchantAction
{
    public function __construct(
        private MerchantRepository $merchantRepository
    ) {}

    public function update(MerchantData $data): MerchantData
    {
        // TODO: Might need to do some validation here.

        $this->merchantRepository->update(new Merchant(
            id: $data->id,
            name: $data->name,
            slug: $data->slug,
            status: $data->status,
            websiteUrl: $data->websiteUrl,
            logoUrl: $data->logoUrl,
        ));

        return $data;
    }
}
