<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\UpdatesOfferAction as UpdatesOfferActionContract;
use Cashback\Offers\DTOs\Actions\UpdateOfferData;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Repositories\OfferRepository;

class UpdateOfferAction implements UpdatesOfferActionContract
{
    public function __construct(
        private OfferRepository $offers,
        private OfferEntityMapper $offerEntityMapper,
    ) {}

    public function update(UpdateOfferData $data): OfferData
    {
        $validated = $data->validate();

        $offerData = $this->offerEntityMapper->mapValidatedUpdateToData($validated);

        $this->offers->update(
            $this->offerEntityMapper->mapDataToEntity($offerData)
        );

        $fresh = $this->offers->find((int) $validated['id']);

        return $this->offerEntityMapper->mapEntityToData($fresh);
    }
}
