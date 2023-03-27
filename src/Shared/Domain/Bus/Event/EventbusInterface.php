<?php

namespace App\Shared\Domain\Bus\Event;

interface EventbusInterface
{
    public function publish(DomainEvent ...$events): void;
}