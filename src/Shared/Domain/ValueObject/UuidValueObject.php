<?php

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

class UuidValueObject extends Uuid implements ValueObjectInterface
{
    private function __construct(private readonly string $uuid)
    {
        $this->ensureUuidIsValid($uuid);

        parent::__construct($uuid);
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
