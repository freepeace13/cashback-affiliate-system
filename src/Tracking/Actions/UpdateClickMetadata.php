<?php

namespace Cashback\Tracking\Actions;

use Cashback\Tracking\Contracts\UpdatesClickMetadataAction;
use Cashback\Tracking\Repositories\ClickRepository;

/**
 * Updates metadata associated with a click (e.g. session, UTM, campaign).
 */
class UpdateClickMetadata implements UpdatesClickMetadataAction
{
    public function __construct(
        private ClickRepository $clickRepository,
    ) {}

    public function update(string $clickRef, array $metadata): void
    {
        $this->clickRepository->updateMetadata($clickRef, $metadata);
    }
}

