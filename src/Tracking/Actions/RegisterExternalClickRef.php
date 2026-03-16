<?php

namespace CashbackAffiliateSystem\Tracking\Actions;

use CashbackAffiliateSystem\Tracking\Contracts\RegistersExternalClickRefAction;
use CashbackAffiliateSystem\Tracking\Repositories\ClickRepository;

/**
 * Registers the network-provided click identifier for an internal click.
 */
class RegisterExternalClickRef implements RegistersExternalClickRefAction
{
    public function __construct(
        private ClickRepository $clickRepository,
    ) {}

    public function register(string $clickRef, string $externalClickRef): void
    {
        $this->clickRepository->registerExternalRef($clickRef, $externalClickRef);
    }
}

