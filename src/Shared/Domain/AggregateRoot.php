<?php

namespace App\Shared\Domain;

use App\Shared\Domain\Bus\Event\DomainEvent;
use App\Shared\Domain\Bus\Event\DomainEventsCollection;

class AggregateRoot
{
    private DomainEventsCollection $events;

    public function recordEvent(DomainEvent $event): void
    {
        if (!isset($this->events)) {
            $this->events = new DomainEventsCollection();
        }

        $this->events->add($event);
    }

    public function fetchEvents(): DomainEventsCollection
    {
        return $this->events;
    }
}