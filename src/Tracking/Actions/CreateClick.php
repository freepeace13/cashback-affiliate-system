<?php

namespace Cashback\Tracking\Actions;

use Cashback\Tracking\Contracts\CreatesClickAction;
use Cashback\Tracking\DTOs\ClickData;
use Cashback\Tracking\DTOs\CreateClickData;
use Cashback\Tracking\Entities\Click;
use Cashback\Tracking\Repositories\ClickRepository;

/**
 * Creates a new tracking Click for a user and offer.
 *
 * This action:
 * - Constructs a Click entity from the provided CreateClickData.
 * - Delegates ID generation and persistence details to the ClickRepository.
 * - Returns a lightweight ClickData projection for callers.
 */
class CreateClick implements CreatesClickAction
{
    public function __construct(
        private ClickRepository $clickRepository,
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

        $saved = $this->clickRepository->save($click);

        return new ClickData(
            id: $saved->id(),
            userId: $saved->userId() ?? '',
            clickRef: $saved->clickRef(),
        );
    }
}

