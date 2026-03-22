<?php

namespace Cashback\Tracking\Actions;

use Cashback\Tracking\Contracts\Actions\UpdatesClickMetadataAction as UpdatesClickMetadataContract;
use Cashback\Tracking\Repositories\ClickWriteRepository;
use Cashback\Tracking\DTOs\Actions\UpdateClickMetadataData;

/**
 * Updates metadata associated with a click (e.g. session, UTM, campaign).
 */
class UpdateClickMetadata implements UpdatesClickMetadataContract
{
    public function __construct(
        private ClickWriteRepository $clicksWriteRepository,
    ) {}

    public function update(UpdateClickMetadataData $data): void
    {
        $this->clicksWriteRepository->updateMetadata($data->clickRef, $data->metadata);
    }
}
