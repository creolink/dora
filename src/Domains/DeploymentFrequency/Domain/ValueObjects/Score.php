<?php

namespace App\Domains\DeploymentFrequency\Domain\ValueObjects;

use App\Shared\Domain\ValueObject\FloatValueObject;

class Score extends FloatValueObject
{
    public static function calculate(int $totalDeployments, int $duration): self
    {
        return self::toFloat($totalDeployments / $duration);
    }
}
