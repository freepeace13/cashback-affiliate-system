<?php

namespace Cashback\Tracking\Actions;

use Cashback\Tracking\Contracts\Actions\AttachesUserToClickAction as AttachesUserToClickContract;
use Cashback\Tracking\Repositories\ClickWriteRepository;
use Cashback\Tracking\DTOs\Actions\AttachUserToClickData;

/**
 * Attaches a logged-in user to an existing click created before login.
 */
class AttachUserToClick implements AttachesUserToClickContract
{
    public function __construct(
        private ClickWriteRepository $clicksWriteRepository,
    ) {}

    public function attach(AttachUserToClickData $data): void
    {
        $this->clicksWriteRepository->attachUser($data->clickRef, $data->userId);
    }
}
