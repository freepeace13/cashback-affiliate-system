<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\UpdatesOfferAction;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Enums\OfferStatus;
use Cashback\Offers\Repositories\OfferRepository;
use Cashback\Offers\ValueObjects\OfferID;
use RuntimeException;

class UpdateOffer implements UpdatesOfferAction
{
    public function __construct(
        private OfferRepository $offerRepository
    ) {}

    public function update(OfferData $data): OfferData
    {
        // TODO: Might need to do some validation here.

        $this->offerRepository->update(new Offer(
            id: $data->id,
            merchantId: $data->merchantId,
            affiliateNetworkId: $data->affiliateNetworkId,
            title: $data->title,
            description: $data->description,
            trackingUrl: $data->trackingUrl,
            cashbackType: $data->cashbackType,
            cashbackValue: (float) $data->cashbackValue,
            currency: $data->currency,
            status: OfferStatus::from($data->status !== '' ? $data->status : 'active'),
        ));

        return $data;
    }
}
