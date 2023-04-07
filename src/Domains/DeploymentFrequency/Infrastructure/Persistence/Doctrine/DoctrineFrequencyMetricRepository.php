<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence\Doctrine;

use App\Domains\DeploymentFrequency\Domain\FrequencyMetric;
use App\Domains\DeploymentFrequency\Domain\FrequencyMetricRepositoryInterface;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\TimeRangeInDays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineFrequencyMetricRepository extends ServiceEntityRepository implements FrequencyMetricRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FrequencyMetric::class);
    }

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

        return $this->findBy([
            'repositoryName' => $repositoryName->value()
        ]);
    }

    public function initData(): void
    {
        //static::$memory = new MemoryStorageCollection();
    }
}
