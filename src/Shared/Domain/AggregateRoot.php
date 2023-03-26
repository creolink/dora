<?php

namespace App\Shared\Domain;

use App\Shared\EventBus\DomainEvent;
use App\Shared\EventBus\DomainEventsCollection;

class AggregateRoot
{
    private DomainEventsCollection $events;

    public function store(DomainEvent $event): void
    {
        if (!$this->events instanceof DomainEventsCollection) {
            $this->events = new DomainEventsCollection();
        }

        $this->events->add($event);
    }

    public function fetch(): DomainEventsCollection
    {
        return $this->events;
    }
}