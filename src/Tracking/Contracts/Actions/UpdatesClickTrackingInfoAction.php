<?php

namespace Cashback\Tracking\Contracts\Actions;

use Cashback\Tracking\DTOs\Actions\UpdateClickTrackingInfoData;

/**
 * Updates device or request details for a click if needed.
 *
 * Writes:
 * - device_type
 * - user_agent
 * - ip_address
 *
 * This is optional but useful for fraud detection.
 */
interface UpdatesClickTrackingInfoAction
{
    public function updateTrackingInfo(UpdateClickTrackingInfoData $data): void;
}
