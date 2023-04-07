<?php

namespace App\Shared\Domain\ValueObject;

class DateTimeValueObject extends \DateTimeImmutable implements ValueObjectInterface
{
    private function __construct(private readonly string $dateTime = '')
    {
        parent::__construct($dateTime);
    }

    public function __toString(): string
    {
        return $this->getFormattedDateTime();
    }

    public function subDays(int $days): self
    {
        return $this->sub(
            new \DateInterval(sprintf('P%sD', $days))
        );
    }

    public static function now(): static
    {
        return new static('now');
    }

    public static function fromString(string $dateTime): static
    {
        return new static($dateTime);
    }

    public function getTimestamp(): int
    {
        return parent::getTimestamp();
    }

    public function getFormattedDateTime(): string
    {
        return parent::format('d/m/Y H:i:s');
    }

    public function getFormattedDate(): string
    {
        return parent::format('d/m/Y');
    }
}
