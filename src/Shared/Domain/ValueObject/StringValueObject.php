<?php

namespace App\Shared\Domain\ValueObject;

class StringValueObject implements ValueObjectInterface
{
    private function __construct(private readonly string $value)
    {
    }

    public static function toString(mixed $value): static
    {
        return new static((string) $value);
    }

    public function value(): string
    {
        return $this->value;
    }
}