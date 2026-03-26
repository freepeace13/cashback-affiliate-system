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

    public function update(int $offerId, UpdateOfferData $data): OfferData
    {
        $offer = $this->offerQueries->find($offerId);
        if ($offer === null) {
            throw new OfferNotFound('Offer not found for update');
        }

        $validated = $data->validate();

        $offer->withTitle($validated['title']);
        $offer->withDescription($validated['description']);
        $offer->withTrackingUrl($validated['trackingUrl']);
        $offer->withCashbackType($validated['cashbackType']);
        $offer->withCashbackValue($validated['cashbackValue']);

        $this->offerCommands->update($offer);

        return $this->offerEntityMapper->mapEntityToData($offer);
    }
}
