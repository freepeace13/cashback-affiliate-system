<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\CreatesOfferAction as CreatesOfferActionContract;
use Cashback\Offers\DTOs\Actions\CreateOfferData;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Enums\OfferStatus;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Repositories\OfferRepository;

class CreateOfferAction implements CreatesOfferActionContract
{
    public function __construct(
        private OfferRepository $offerRepository,
        private OfferEntityMapper $offerEntityMapper,
    ) {}

    public function create(CreateOfferData $data): OfferData
    {
        $created = $this->offerRepository->create(
            $this->createOfferEntity($data)
        );

        return $this->offerEntityMapper->mapEntityToData($created);
    }

    protected function createOfferEntity(CreateOfferData $data): Offer
    {
        $validated = $data->validate();

        return new Offer(
            id: -1,
            merchantId: $validated['merchantId'],
            affiliateNetworkId: $validated['affiliateNetworkId'],
            title: $validated['title'],
            description: $validated['description'] !== '' ? $validated['description'] : null,
            trackingUrl: $validated['trackingUrl'],
            cashbackType: $validated['cashbackType'],
            cashbackValue: (float) $validated['cashbackValue'],
            currency: $validated['currency'],
            status: OfferStatus::from($validated['status'] !== '' ? $validated['status'] : 'active'),
        );
    }
}
