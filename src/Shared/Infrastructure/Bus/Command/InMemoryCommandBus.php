<?php

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\Event;

class InMemoryCommandBus implements CommandBusInterface
{
    public function __construct(private EventDispatcherInterface $eventDispatcher)
    {
    }

    public function dispatch(CommandInterface ...$commands): void
    {
        foreach ($commands as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}