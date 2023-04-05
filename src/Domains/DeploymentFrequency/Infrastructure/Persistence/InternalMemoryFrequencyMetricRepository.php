<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence;

use App\Domains\DeploymentFrequency\Domain\Deployment;
use App\Domains\DeploymentFrequency\Domain\FrequencyMetricRepositoryInterface;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\TimeRangeInDays;
use App\Domains\DeploymentFrequency\Infrastructure\Persistence\InternalMemory\InternalMemoryDataStorage;

class InternalMemoryFrequencyMetricRepository extends InternalMemoryDataStorage implements
    FrequencyMetricRepositoryInterface
{
    public function getDeployments(
        RepositoryName $repositoryName,
        TimeRangeInDays $timeRange,
        ?Author $author
    ): ?array {
        $startDateTime = (new \DateTimeImmutable())
            ->sub(
                new \DateInterval(sprintf('P%sD', $timeRange->value()))
            )
        ;

        return static::$memory->filter(
            function (Deployment $deployment) use ($repositoryName, $startDateTime, $author) {
                return $deployment->getRepositoryName()->value() == $repositoryName->value()
                    && (null === $author || $deployment->getAuthor()->value() === $author->value())
                    && $deployment->getDeploymentTime()->getTimestamp() >= $startDateTime->getTimestamp()
                ;
            }
        )->toArray();
    }
}
