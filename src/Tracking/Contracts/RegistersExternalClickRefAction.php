<?php

namespace Cashback\Tracking\Contracts;

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
    public function register(string $clickRef, string $externalClickRef): void;
}
