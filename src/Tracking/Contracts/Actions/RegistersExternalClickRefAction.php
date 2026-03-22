<?php

namespace Cashback\Tracking\Contracts\Actions;

use Cashback\Tracking\DTOs\Actions\RegisterExternalClickRefData;

/**
 * Stores the network-provided click identifier alongside the internal click.
 *
 * Writes:
 * - clicks.external_click_ref
 *
 * Inputs:
 * - click_ref (internal click identifier)
 * - external_click_ref (network-provided click identifier)
 *
 * This helps networks that later reference their own click ID.
 */
interface RegistersExternalClickRefAction
{
    public function register(RegisterExternalClickRefData $data): void;
}
