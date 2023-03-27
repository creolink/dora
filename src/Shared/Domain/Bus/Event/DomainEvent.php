<?php

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\AggregateRoot;

class DomainEvent
{
    private static int $eventId = 0;

    public function __construct(private readonly AggregateRoot $eventPayload)
    {
        self::$eventId++;
    }
}