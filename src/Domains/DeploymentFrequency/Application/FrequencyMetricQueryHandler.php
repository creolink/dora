<?php

namespace App\Domains\DeploymentFrequency\Application;

use App\Domains\DeploymentFrequency\Domain\DeploymentRepositoryInterface;
use App\Domains\DeploymentFrequency\Domain\FrequencyMetric;
use App\Domains\DeploymentFrequency\Domain\FrequencyMetricRepositoryInterface;
use App\Shared\Domain\Bus\Query\QueryHandlerInterface;

class FrequencyMetricQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly DeploymentRepositoryInterface $deploymentRepository
    ) {
    }

    public function __invoke(FrequencyMetricQuery $query): FrequencyMetric
    {
        $deployments = $this->deploymentRepository->findByRepositoryAndTime(
            $query->getRepositoryName(),
            $query->getTimeRangeInDays(),
            $query->getAuthor()
        );

        return new FrequencyMetric(
            $query->getRepositoryName(),
            $query->getTimeRangeInDays(),
            $query->getAuthor(),
            $deployments
        );
    }
}
