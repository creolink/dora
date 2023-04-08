<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence\Doctrine\Type;

use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentId;
use App\Shared\Domain\ValueObject\UuidValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class DeploymentIdType extends StringType
{
    public const TYPE_NAME = 'uuid';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return new DeploymentId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        /** @var UuidValueObject $value */
        return $value->value();
    }
}
