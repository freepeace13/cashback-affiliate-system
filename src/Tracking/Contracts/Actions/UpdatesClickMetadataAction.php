<?php

namespace Cashback\Tracking\Contracts\Actions;

use Cashback\Tracking\DTOs\Actions\UpdateClickMetadataData;

/**
 * Allows enrichment of click metadata after creation.
 *
 * Writes:
 * - clicks.metadata
 *
 * Example updates:
 * - session id
 * - utm parameters
 * - campaign id
 */
interface UpdatesClickMetadataAction
{
    /**
     * @param array<string,mixed> $metadata Partial metadata to merge into the click.
     */
    public function update(UpdateClickMetadataData $data): void;
}
