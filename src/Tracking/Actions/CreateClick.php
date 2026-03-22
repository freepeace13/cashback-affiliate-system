<?php

namespace Cashback\Tracking\Actions;

use Cashback\Contracts\EventBus;
use Cashback\Tracking\Contracts\Actions\CreatesClickAction as CreatesClickContract;
use Cashback\Tracking\DTOs\ClickData;
use Cashback\Tracking\DTOs\Actions\CreateClickData;
use Cashback\Tracking\Entities\Click;
use Cashback\Tracking\Events\ClickCreated;
use Cashback\Tracking\Repositories\ClickWriteRepository;
use Cashback\Tracking\Mappers\ClickEntityMapper;

/**
 * Creates a new tracking Click for a user and offer.
 *
 * This action:
 * - Constructs a Click entity from the provided CreateClickData.
 * - Delegates ID generation and persistence details to the ClickWriteRepository.
 * - Returns a lightweight ClickData projection for callers.
 */
class CreateClick implements CreatesClickContract
{
    public function __construct(
        private ClickWriteRepository $clicksWriteRepository,
        private ClickEntityMapper $clickEntityMapper,
        private EventBus $eventBus,
    ) {}

    public function create(CreateClickData $data): ClickData
    {
        $clickRef = bin2hex(random_bytes(16));
        $click = new Click(
            id: '',
            clickRef: $clickRef,
            userId: $data->userId !== '' ? $data->userId : null,
            merchantId: (int) $data->merchantId,
            offerId: $data->offerId !== '' ? (int) $data->offerId : null,
            affiliateNetworkId: (int) $data->affiliateNetworkId,
            destinationUrl: $data->destinationUrl,
            trackingUrl: $data->trackingUrl,
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
