<?php

namespace App\Domains\DeploymentFrequency\Domain;

use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\TimeRangeInDays;

interface FrequencyMetricRepositoryInterface
{
    public function getDeployments(
        RepositoryName  $repositoryName,
        TimeRangeInDays $timeRange,
        ?Author         $author
    ): array;
}