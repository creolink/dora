<?php

namespace App\Domains\DeploymentFrequency\Domain;

use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\Score;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\TimeRangeInDays;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Bus\Query\ResponseInterface;

class FrequencyMetric extends AggregateRoot implements ResponseInterface
{
    public function __construct(
        private readonly RepositoryName $repositoryName,
        private readonly TimeRangeInDays $timeRange,
        private readonly ?Author $author,
        private readonly ?array $deployments
    ) {
        if ($timeRange->value() <= 0) {
            throw new \Exception('Time range must be provided in days. It must be a positive value.');
        }
    }

    public function getRepositoryName(): RepositoryName
    {
        return $this->repositoryName;
    }

    public function getTimeRange(): TimeRangeInDays
    {
        return $this->timeRange;
    }

    public function getDeployments(): array
    {
        return $this->deployments;
    }

    public function calculateScore(): Score
    {
        return Score::toFloat(count($this->deployments) / $this->timeRange->value());
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }
}
