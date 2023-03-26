<?php

namespace App\Shared\EventBus;

use App\Shared\Domain\AggregateRoot;

class DomainEvent
{
    private static $eventId = 0;

    public function __construct(private AggregateRoot $eventPayload)
    {
        self::$eventId++;
    }
}