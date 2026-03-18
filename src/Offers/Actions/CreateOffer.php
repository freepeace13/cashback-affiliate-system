<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\CreatesOfferAction;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Enums\OfferStatus;
use Cashback\Offers\Repositories\OfferRepository;

class CreateOffer implements CreatesOfferAction
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    public function create(OfferData $data): OfferData
    {
        $created = $this->offerRepository->create(new Offer(
            id: 0,
            merchantId: $data->merchantId,
            affiliateNetworkId: $data->affiliateNetworkId,
            title: $data->title,
            description: $data->description !== '' ? $data->description : null,
            trackingUrl: $data->trackingUrl,
            cashbackType: $data->cashbackType,
            cashbackValue: (float) $data->cashbackValue,
            currency: $data->currency,
            status: OfferStatus::from($data->status !== '' ? $data->status : 'active'),
            startsAt: null,
            endsAt: null,
        ));

        return new OfferData(
            id: $created->id(),
            title: $data->title,
            description: $data->description,
            trackingUrl: $data->trackingUrl,
            cashbackType: $data->cashbackType,
            cashbackValue: $data->cashbackValue,
            currency: $data->currency,
            status: $data->status,
            merchantId: $created->merchantId(),
            affiliateNetworkId: $created->affiliateNetworkId(),
        );
    }
}
