<?php

namespace App\Domains\DeploymentFrequency\Domain;

use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\Score;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\TimeRangeInDays;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Bus\Query\ResponseInterface;
use App\Shared\Domain\ValueObject\DateTimeValueObject;

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

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function getStartDate(): DateTimeValueObject
    {
        return DateTimeValueObject::subDays($this->timeRange->value());
    }

    public function getEndDate(): DateTimeValueObject
    {
        return DateTimeValueObject::now();
    }

    public function calculateScore(): Score
    {
        return Score::calculate(count($this->deployments), $this->timeRange->value());
    }

    public function toResponse(): array
    {
        return [
            'repository' => $this->getRepositoryName()->value(),
            'from' => $this->getStartDate()->getFormattedDate(),
            'to' => $this->getEndDate()->getFormattedDate(),
            'duration_in_days' => $this->getTimeRange()->value(),
            'score' => $this->calculateScore()->roundedValue(2),
        ];
    }
}
