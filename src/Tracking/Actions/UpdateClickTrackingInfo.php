<?php

namespace Cashback\Tracking\Actions;

use Cashback\Tracking\Contracts\UpdatesClickTrackingInfoAction;
use Cashback\Tracking\Repositories\ClickRepository;

/**
 * Updates device or request tracking information for a click.
 */
class UpdateClickTrackingInfo implements UpdatesClickTrackingInfoAction
{
    public function __construct(
        private ClickRepository $clickRepository,
    ) {}

    public function updateTrackingInfo(
        string $clickRef,
        ?string $deviceType,
        ?string $userAgent,
        ?string $ipAddress,
    ): void {
        $this->clickRepository->updateTrackingInfo(
            $clickRef,
            $deviceType,
            $userAgent,
            $ipAddress,
        );
    }
}

