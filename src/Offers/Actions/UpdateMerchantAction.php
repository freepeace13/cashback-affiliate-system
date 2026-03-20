<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\UpdatesMerchantAction as UpdatesMerchantActionContract;
use Cashback\Offers\DTOs\Actions\UpdateMerchantData;
use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\Mappers\MerchantEntityMapper;
use Cashback\Offers\Repositories\MerchantRepository;

class UpdateMerchantAction implements UpdatesMerchantActionContract
{
    public function __construct(
        private MerchantRepository $merchants,
        private MerchantEntityMapper $merchantEntityMapper,
    ) {}

    public function update(UpdateMerchantData $data): MerchantData
    {
        $validated = $data->validate();

        $merchantData = $this->merchantEntityMapper->mapValidatedUpdateToData($validated);

        $this->merchants->update(
            $this->merchantEntityMapper->mapDataToEntity($merchantData)
        );

        $fresh = $this->merchants->find((int) $validated['id']);

        return $this->merchantEntityMapper->mapEntityToData($fresh);
    }
}
