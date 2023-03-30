<?php

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Shared\Domain\Bus\Event\EventbusInterface;

class InternalInMemoryEventBus implements EventbusInterface
{
    private static array $events = [];

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            self::$events[] = $event;
        }
    }
}