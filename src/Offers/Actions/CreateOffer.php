<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\CreatesOfferAction;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Repositories\OfferRepository;

class CreateOffer implements CreatesOfferAction
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    public function create(OfferData $data): OfferData
    {
        $offer = new Offer(
            id: '', // ID generation is delegated to the persistence layer.
            name: $data->name,
            description: $data->description,
            trackingUrl: $data->trackingUrl,
            cashbackType: $data->cashbackType,
            cashbackValue: $data->cashbackValue,
            currency: $data->currency,
            status: $data->status,
            createdAt: $data->createdAt,
            updatedAt: $data->updatedAt,
        );

        $this->offerRepository->create($offer);

        return $data;
    }
}

