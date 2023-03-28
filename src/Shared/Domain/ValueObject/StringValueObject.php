<?php

namespace App\Shared\Domain\ValueObject;

class StringValueObject implements ValueObjectInterface
{
    private function __construct(private readonly mixed $value)
    {
    }

    public static function toString($value): static
    {
        return new static((string) $value);
    }

    public function value(): string
    {
        return $this->value;
    }
}