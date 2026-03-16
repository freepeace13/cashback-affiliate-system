<?php

namespace CashbackAffiliateSystem\Offers\Actions;

use CashbackAffiliateSystem\Offers\Entities\Offer;
use CashbackAffiliateSystem\Offers\Repositories\OfferRepository;
use CashbackAffiliateSystem\Offers\DTOs\OfferData;
use CashbackAffiliateSystem\Offers\Contracts\UpdatesOfferAction;
use CashbackAffiliateSystem\Offers\ValueObjects\OfferID;
use RuntimeException;

class UpdateOffer implements UpdatesOfferAction
{
    public function __construct(
        private OfferRepository $offerRepository
    ) {}

    public function update(OfferID $id, OfferData $data): OfferData
    {
        $existing = $this->offerRepository->find($id);

        if (! $existing instanceof Offer) {
            throw new RuntimeException('Offer not found for ID '.$id->value());
        }

        $updated = new Offer(
            id: $existing->id,
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

        $this->offerRepository->update($id, $updated);

        // Map entity back to DTO so callers only see DTOs.
        return new OfferData(
            name: $updated->name,
            description: $updated->description,
            trackingUrl: $updated->trackingUrl,
            cashbackType: $updated->cashbackType,
            cashbackValue: $updated->cashbackValue,
            currency: $updated->currency,
            status: $updated->status,
            createdAt: $updated->createdAt,
            updatedAt: $updated->updatedAt,
        );
    }
}