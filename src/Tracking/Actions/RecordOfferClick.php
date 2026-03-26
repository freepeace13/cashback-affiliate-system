<?php

namespace Cashback\Tracking\Actions;

use Cashback\Contracts\EventBus;
use Cashback\Offers\Repositories\OfferQueryRepository;
use Cashback\Tracking\Contracts\Actions\RecordsOfferClickAction as RecordsOfferClickContract;
use Cashback\Tracking\DTOs\Actions\RecordOfferClickData;
use Cashback\Tracking\DTOs\ClickData;
use Cashback\Tracking\Entities\Click;
use Cashback\Tracking\Events\ClickCreated;
use Cashback\Tracking\Exceptions\OfferNotFoundForClick;
use Cashback\Tracking\Mappers\ClickEntityMapper;
use Cashback\Tracking\Repositories\ClickWriteRepository;

final class RecordOfferClick implements RecordsOfferClickContract
{
    public function __construct(
        private ClickWriteRepository $clicksWriteRepository,
        private ClickEntityMapper $clickEntityMapper,
        private EventBus $eventBus,
        private OfferQueryRepository $offerQueries,
    ) {}

    public function record(RecordOfferClickData $data): ClickData
    {
        $offer = $this->offerQueries->find($data->offerId);
        if ($offer === null) {
            throw new OfferNotFoundForClick("Offer {$data->offerId} not found for click recording");
        }

        $clickRef = bin2hex(random_bytes(16));
        $click = new Click(
            id: '',
            clickRef: $clickRef,
            userId: $data->userId,
            merchantId: $offer->merchantId(),
            offerId: $offer->id(),
            affiliateNetworkId: $offer->affiliateNetworkId(),
            destinationUrl: $data->destinationUrl,
            trackingUrl: $offer->trackingUrl(),
            clickedAt: new \DateTimeImmutable(),
        );

        $saved = $this->clicksWriteRepository->save($click);
        $click = $click->withId($saved->id());
        $clickData = $this->clickEntityMapper->mapEntityToData($click);

        $this->eventBus->publish(new ClickCreated(
            clickData: $clickData,
            createdAt: new \DateTimeImmutable(),
        ));

        return $clickData;
    }
}
