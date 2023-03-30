<?php

namespace App\Shared\Domain\ValueObject;

class IntValueObject implements ValueObjectInterface
{
    private function __construct(private readonly int $value)
    {
    }

    public static function toInt(mixed $value): static
    {
        return new static((int) $value);
    }

    public function value(): int
    {
        return $this->value;
    }
}