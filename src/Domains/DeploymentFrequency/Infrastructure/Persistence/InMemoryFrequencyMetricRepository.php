<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence;

use App\Domains\DeploymentFrequency\Domain\FrequencyMetricRepositoryInterface;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\TimeRangeInDays;

class InMemoryFrequencyMetricRepository implements FrequencyMetricRepositoryInterface
{
    private static array $memory = [];

    public function getDeployments(
        RepositoryName  $repositoryName,
        TimeRangeInDays $timeRange,
        ?Author         $author
    ): array {

        return self::$memory[$repositoryName->value()][$timeRange->value()];
    }
}