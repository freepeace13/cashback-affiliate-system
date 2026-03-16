<?php

namespace CashbackAffiliateSystem\Tracking\Actions;

use CashbackAffiliateSystem\Tracking\Contracts\CreatesClickAction;
use CashbackAffiliateSystem\Tracking\DTOs\ClickData;
use CashbackAffiliateSystem\Tracking\DTOs\CreateClickData;
use CashbackAffiliateSystem\Tracking\Entities\Click;
use CashbackAffiliateSystem\Tracking\Repositories\ClickRepository;

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
        $click = new Click(
            id: '', // ID generation is delegated to the persistence layer.
            userId: $data->userId,
        );

        $this->clickRepository->save($click);

        return new ClickData(
            id: $click->id,
            userId: $click->userId,
        );
    }
}

