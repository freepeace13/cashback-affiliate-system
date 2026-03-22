<?php

namespace Cashback\Tests\Doubles;

use Cashback\Contracts\EventBus as EventBusContract;

class EventBus implements EventBusContract
{
    /** @var array<string, array<int, callable>> */
    protected array $subscribers = [];

    public function publish($event): void
    {
        $registeredEvent = $this->resolveEventName($event);

        foreach ($this->getEventSubscribers($registeredEvent) as $subscriber) {
            call_user_func($subscriber['listener'], $event);
        }
    }

    public function subscribe(string $event, callable $listener): void
    {
        $eventName = $this->resolveEventName($event);

        $this->subscribers[$eventName] = $this->subscribers[$eventName] ?? [];
        $this->subscribers[$eventName][] = $listener;
    }

    protected function resolveEventName($event): string
    {
        return is_object($event) ? get_class($event) : $event;
    }

    protected function getEventSubscribers(string $event): array
    {
        return array_values(array_filter($this->subscribers, fn($subscriber) => $subscriber['event'] === $event));
    }
}
