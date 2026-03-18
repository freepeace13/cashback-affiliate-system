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

        return new MerchantData(
            name: $merchant->name(),
            slug: $merchant->slug(),
            websiteUrl: $merchant->websiteUrl(),
            logoUrl: $merchant->logoUrl() ?? '',
            status: $merchant->status(),
            createdAt: '',
            updatedAt: '',
        );
    }
}
