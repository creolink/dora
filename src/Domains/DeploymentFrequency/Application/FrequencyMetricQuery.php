<?php

namespace App\Domains\DeploymentFrequency\Application;

use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\TimeRangeInDays;
use App\Shared\Domain\Bus\Query\QueryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class FrequencyMetricQuery implements QueryInterface
{
    public function __construct(
        private readonly RepositoryName $repositoryName,
        private readonly TimeRangeInDays $timeRangeInDays,
        private readonly ?Author $author
    ){
    }

    public function getUuid(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function getRepositoryName(): RepositoryName
    {
        return $this->repositoryName;
    }

    public function getTimeRangeInDays(): TimeRangeInDays
    {
        return $this->timeRangeInDays;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }
}