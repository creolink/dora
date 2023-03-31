<?php

namespace App\Shared\Domain\Bus\Query;

use Ramsey\Uuid\UuidInterface;

interface QueryInterface
{
    public function getUuid(): UuidInterface;
}
