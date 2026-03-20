<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\ListActiveMerchantsQueryHandler;
use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\DTOs\Queries\ListActiveMerchantsQuery;
use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\Mappers\MerchantEntityMapper;
use Cashback\Offers\Repositories\MerchantRepository;

class ListActiveMerchantsHandler implements ListActiveMerchantsQueryHandler
{
    public function __construct(
        private MerchantRepository $merchantRepository,
        private MerchantEntityMapper $merchantEntityMapper,
    ) {}

    /**
     * @return MerchantData[]
     */
    public function handle(ListActiveMerchantsQuery $query): array
    {
        $merchants = $this->merchantRepository->listActiveMerchants();

        return array_map(
            fn (Merchant $merchant): MerchantData => $this->merchantEntityMapper->mapEntityToData($merchant),
            $merchants
        );
    }
}
