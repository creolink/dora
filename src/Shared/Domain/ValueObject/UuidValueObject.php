<?php

namespace App\Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;

class UuidValueObject implements ValueObjectInterface
{
    private function __construct(private readonly string $uuid)
    {
        $this->ensureUuidIsValid($uuid);
    }

    public static function init(): static
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    public function value(): string
    {
        return $this->uuid;
    }

    private function ensureUuidIsValid(string $uuid): void
    {
        RamseyUuid::isValid($uuid);
    }
}