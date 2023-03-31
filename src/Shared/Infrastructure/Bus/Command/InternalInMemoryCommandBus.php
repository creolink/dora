<?php

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class InternalInMemoryCommandBus implements CommandBusInterface
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
