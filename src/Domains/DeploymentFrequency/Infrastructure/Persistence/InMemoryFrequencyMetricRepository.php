<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence;

use App\Domains\DeploymentFrequency\Domain\FrequencyMetricRepositoryInterface;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\TimeRangeInDays;
use App\Domains\DeploymentFrequency\Infrastructure\Persistence\InternalMemory\InternalMemoryDataStorage;

class InMemoryFrequencyMetricRepository extends InternalMemoryDataStorage implements FrequencyMetricRepositoryInterface
{
    public function getDeployments(
        RepositoryName  $repositoryName,
        TimeRangeInDays $timeRange,
        ?Author         $author
    ): ?array {

        return null;


        return self::$deployments[$repositoryName->value()][$timeRange->value()];
    }
}