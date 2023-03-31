<?php

namespace App\Shared\Domain\Bus\Command;

interface CommandBusInterface
{
    public function dispatch(CommandInterface ...$commands): void;
}
