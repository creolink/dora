<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence\Doctrine;

use App\Domains\DeploymentFrequency\Domain\Deployment;
use App\Domains\DeploymentFrequency\Domain\DeploymentRepositoryInterface;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\TimeRangeInDays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineDeploymentRepository extends ServiceEntityRepository implements DeploymentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deployment::class);
    }

    public function save(Deployment $deployment): void
    {
        dump($deployment);

        $this->getEntityManager()->persist($deployment);

        $this->getEntityManager()->flush();

        dump('SAVED IN DB Doctrine'); //, $deployment
    }

    public function findByRepositoryAndTime(
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
            "repositoryName.value" => $repositoryName->value()
        ]);
    }

    public function initData(): void
    {
        //static::$memory = new MemoryStorageCollection();
    }
}
