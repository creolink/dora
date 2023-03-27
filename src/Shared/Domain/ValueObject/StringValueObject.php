<?php

namespace App\Shared\Domain\ValueObject;

class StringValueObject implements ValueObjectInterface
{
    public function __construct(private mixed $value)
    {
    }

    public static function toString($value): static
    {
        return new static((string) $value);
    }
}