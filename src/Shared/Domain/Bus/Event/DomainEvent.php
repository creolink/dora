<?php

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\AggregateRoot;
use Symfony\Contracts\EventDispatcher\Event;

class DomainEvent extends Event
{
    private static int $eventId = 0;

    public function __construct(private readonly AggregateRoot $eventPayload)
    {
        ++self::$eventId;
    }
}
