<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\UpdatesOfferAction as UpdatesOfferActionContract;
use Cashback\Offers\DTOs\Actions\UpdateOfferData;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Exceptions\OfferNotFound;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Repositories\OfferCommandRepository;
use Cashback\Offers\Repositories\OfferQueryRepository;

class UpdateOfferAction implements UpdatesOfferActionContract
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferCommandRepository $offerCommands,
        private OfferEntityMapper $offerEntityMapper,
    ) {}

    public function update(UpdateOfferData $data): OfferData
    {
        $validated = $data->validate();
        $id = (int) $validated['id'];

        $existing = $this->offerQueries->find($id);
        if ($existing === null) {
            throw new OfferNotFound('Offer not found for update');
        }

        $offerData = $this->offerEntityMapper->mapValidatedUpdateToData($validated, $existing);

        Offer::ensureValidAvailabilityWindow($offerData->startsAt, $offerData->endsAt);

        $this->offerCommands->update(
            $this->offerEntityMapper->mapDataToEntity($offerData)
        );

        $fresh = $this->offerQueries->find($id);

        return $this->offerEntityMapper->mapEntityToData($fresh);
    }
}
