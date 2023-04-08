<?php

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

class UuidValueObject implements ValueObjectInterface
{
    public function __construct(private readonly string $uuid)
    {
        $this->ensureUuidIsValid($uuid);
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public static function generate(): static
    {
        return new static(Uuid::v4()->toRfc4122());
    }

    public function value(): string
    {
        return $this->uuid;
    }

    private function ensureUuidIsValid(string $uuid): void
    {
        Uuid::isValid($uuid);
    }
}
