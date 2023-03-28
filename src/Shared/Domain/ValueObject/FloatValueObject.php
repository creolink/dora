<?php

namespace App\Shared\Domain\ValueObject;

class FloatValueObject implements ValueObjectInterface
{
    private function __construct(private readonly mixed $value)
    {
    }

    public static function toFloat($value): static
    {
        return new static((float) $value);
    }

    public function value(): float
    {
        return $this->value;
    }
}