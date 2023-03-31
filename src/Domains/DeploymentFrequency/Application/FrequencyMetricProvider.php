<?php

namespace App\Domains\DeploymentFrequency\Application;

use App\Domains\DeploymentFrequency\Domain\FrequencyMetric;
use App\Shared\Domain\Bus\Query\QueryBusInterface;
use App\Shared\Domain\Bus\Query\QueryInterface;

class FrequencyMetricProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(QueryInterface $frequencyMetricQuery): FrequencyMetric
    {
        return $this->queryBus->ask($frequencyMetricQuery);
    }
}
