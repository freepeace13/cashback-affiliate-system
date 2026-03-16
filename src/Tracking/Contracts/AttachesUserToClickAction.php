<?php

namespace CashbackAffiliateSystem\Tracking\Contracts;

/**
 * Handles the case where a click was created before the user logged in.
 *
 * Writes:
 * - clicks.user_id
 *
 * Inputs:
 * - click_ref (internal click identifier)
 * - user_id
 *
 * Result:
 * - Click updated with the associated user.
 */
interface AttachesUserToClickAction
{
    public function attach(string $clickRef, string $userId): void;
}
