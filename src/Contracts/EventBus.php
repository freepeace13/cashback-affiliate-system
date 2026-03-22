<?php

namespace Cashback\Contracts;

interface EventBus
{
    public function publish($event): void;

    public function subscribe(string $event, callable $callback): void;
}
