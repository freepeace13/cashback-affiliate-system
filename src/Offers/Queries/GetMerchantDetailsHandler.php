<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\GetMerchantDetailsQueryHandler;
use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\DTOs\Queries\GetMerchantDetailsQuery;
use Cashback\Offers\Mappers\MerchantEntityMapper;
use Cashback\Offers\Repositories\MerchantRepository;

class GetMerchantDetailsHandler implements GetMerchantDetailsQueryHandler
{
    public function __construct(
        private MerchantRepository $merchantRepository,
        private MerchantEntityMapper $merchantEntityMapper,
    ) {}

    public function handle(GetMerchantDetailsQuery $query): ?MerchantData
    {
        $identifier = $query->merchantId;

        if (is_int($identifier) || ctype_digit((string) $identifier)) {
            $merchant = $this->merchantRepository->find((int) $identifier);
        } else {
            $merchant = $this->merchantRepository->findBySlug((string) $identifier);
        }

        if ($merchant === null) {
            return null;
        }

        return $this->merchantEntityMapper->mapEntityToData($merchant);
    }
}
