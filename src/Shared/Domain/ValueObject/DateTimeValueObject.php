<?php

namespace App\Shared\Domain\ValueObject;

class DateTimeValueObject implements ValueObjectInterface
{
    private function __construct(private readonly \DateTimeInterface $dateTime)
    {
    }

    public static function subDays(int $days): static
    {
        return new static(
            (new \DateTimeImmutable())
                ->sub(
                    new \DateInterval(sprintf('P%sD', $days))
                )
        );
    }

    public static function now(): static
    {
        return new static(new \DateTimeImmutable());
    }

    public static function fromString(string $dateTime): static
    {
        return new static(new \DateTimeImmutable($dateTime));
    }

    public function getTimestamp(): int
    {
        return $this->dateTime->getTimestamp();
    }

    public function getFormattedDateTime(): string
    {
        return $this->dateTime->format('d/m/Y H:i:s');
    }

    public function getFormattedDate(): string
    {
        return $this->dateTime->format('d/m/Y');
    }
}
