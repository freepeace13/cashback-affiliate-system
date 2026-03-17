<?php

namespace Cashback\Offers\Queries\GetMerchantDetails;

use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\Repositories\MerchantRepository;
use Cashback\Offers\ValueObjects\MerchantID;

class GetMerchantDetailsHandler
{
    public function __construct(
        private MerchantRepository $merchantRepository,
    ) {}

    public function handle(GetMerchantDetailsQuery $query): ?MerchantData
    {
        $identifier = $query->merchantId;

        if (is_int($identifier) || ctype_digit((string) $identifier)) {
            $merchant = $this->merchantRepository->find(new MerchantID((string) $identifier));
        } else {
            $merchant = $this->merchantRepository->findBySlug((string) $identifier);
        }

        if ($merchant === null) {
            return null;
        }

        // Entity is very minimal; we map what we have and leave others empty.
        return new MerchantData(
            name: $merchant->name,
            slug: $merchant->id,
            websiteUrl: '',
            logoUrl: '',
            status: '',
            createdAt: '',
            updatedAt: '',
        );
    }
}
