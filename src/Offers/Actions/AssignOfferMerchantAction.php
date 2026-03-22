<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\AssignOfferMerchantAction as AssignOfferMerchantActionContract;
use Cashback\Offers\Exceptions\MerchantNotFound;
use Cashback\Offers\Exceptions\OfferNotFound;
use Cashback\Offers\Repositories\MerchantRepository;
use Cashback\Offers\Repositories\OfferCommandRepository;
use Cashback\Offers\Repositories\OfferQueryRepository;

class AssignOfferMerchantAction implements AssignOfferMerchantActionContract
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferCommandRepository $offerCommands,
        private MerchantRepository $merchantRepository,
    ) {}

    public function assign(int $offerId, int $merchantId): void
    {
        $offer = $this->offerQueries->find($offerId);
        if ($offer === null) {
            throw new OfferNotFound("Offer {$offerId} not found");
        }

        if ($this->merchantRepository->find($merchantId) === null) {
            throw new MerchantNotFound("Merchant {$merchantId} not found");
        }

        $this->offerCommands->update($offer->withMerchantId($merchantId));
    }
}
