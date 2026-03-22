<?php

namespace Cashback\Tracking\Actions;

use Cashback\Tracking\Contracts\Actions\UpdatesClickTrackingInfoAction as UpdatesClickTrackingInfoContract;
use Cashback\Tracking\DTOs\Actions\UpdateClickTrackingInfoData;
use Cashback\Tracking\Repositories\ClickWriteRepository;

/**
 * Updates device or request tracking information for a click.
 */
class UpdateClickTrackingInfo implements UpdatesClickTrackingInfoContract
{
    public function __construct(
        private ClickWriteRepository $clicksWriteRepository,
    ) {}

    public function updateTrackingInfo(UpdateClickTrackingInfoData $data): void
    {
        $this->clicksWriteRepository->updateTrackingInfo(
            $data->clickRef,
            $data->deviceType,
            $data->userAgent,
            $data->ipAddress,
        );
    }
}
