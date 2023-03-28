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
        private readonly RepositoryName  $repositoryName,
        private readonly TimeRangeInDays $timeRange,
        private readonly Score           $score,
        private readonly ?Author         $author
    ) {
    }

    public function getRepositoryName(): RepositoryName
    {
        return $this->repositoryName;
    }

    public function getTimeRange(): TimeRangeInDays
    {
        return $this->timeRange;
    }

    public function getScore(): Score
    {
        return $this->score;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }
}