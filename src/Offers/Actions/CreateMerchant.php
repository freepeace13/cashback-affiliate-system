<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\Repositories\MerchantRepository;
use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\Contracts\CreatesMerchantAction;

class CreateMerchant implements CreatesMerchantAction
{
    public function __construct(
        private MerchantRepository $merchantRepository
    ) {}

    public function create(MerchantData $data): MerchantData
    {
        // TODO: Might need to do some validation here.

        $created = $this->merchantRepository->create(
            new Merchant(
                id: 0,
                name: $data->name,
                slug: $data->slug,
                status: $data->status !== '' ? $data->status : 'active',
                websiteUrl: $data->websiteUrl,
                logoUrl: $data->logoUrl !== '' ? $data->logoUrl : null,
            )
        );

        return new MerchantData(
            id: $created->id(),
            name: $created->name(),
            slug: $created->slug(),
            status: $created->status(),
            websiteUrl: $created->websiteUrl(),
            logoUrl: $created->logoUrl(),
        );
    }
}
