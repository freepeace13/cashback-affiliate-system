<?php

namespace Cashback\Tracking\Contracts\Actions;

use Cashback\Tracking\DTOs\ClickData;
use Cashback\Tracking\DTOs\Actions\CreateClickData;

/**
 * Action contract for creating a tracking click.
 *
 * Implementations should:
 * - Persist a new Click entity using the Tracking repositories.
 * - Enforce any Tracking invariants around click creation.
 * - Return a lightweight ClickData projection for callers.
 */
interface CreatesClickAction
{
    public function create(CreateClickData $data): ClickData;
}
