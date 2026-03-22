<?php

namespace Cashback\Tracking\Actions;

use Cashback\Tracking\Contracts\Actions\RegistersExternalClickRefAction as RegistersExternalClickRefContract;
use Cashback\Tracking\Repositories\ClickWriteRepository;
use Cashback\Tracking\DTOs\Actions\RegisterExternalClickRefData;

/**
 * Registers the network-provided click identifier for an internal click.
 */
class RegisterExternalClickRef implements RegistersExternalClickRefContract
{
    public function __construct(
        private ClickWriteRepository $clicksWriteRepository,
    ) {}

    public function register(RegisterExternalClickRefData $data): void
    {
        $this->clicksWriteRepository->registerExternalRef($data->clickRef, $data->externalClickRef);
    }
}
