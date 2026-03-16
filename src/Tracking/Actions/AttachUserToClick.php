<?php

namespace CashbackAffiliateSystem\Tracking\Actions;

use CashbackAffiliateSystem\Tracking\Contracts\AttachesUserToClickAction;
use CashbackAffiliateSystem\Tracking\Repositories\ClickRepository;

/**
 * Attaches a logged-in user to an existing click created before login.
 */
class AttachUserToClick implements AttachesUserToClickAction
{
    public function __construct(
        private ClickRepository $clickRepository,
    ) {}

    public function attach(string $clickRef, string $userId): void
    {
        $this->clickRepository->attachUser($clickRef, $userId);
    }
}

