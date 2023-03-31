<?php

namespace App\Domains\DeploymentFrequency\Application;

use App\Domains\DeploymentFrequency\Domain\Deployment;
use App\Domains\DeploymentFrequency\Domain\DeploymentRepositoryInterface;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentTime;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\ReleaseId;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\ReleaseName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Shared\Domain\Bus\Event\EventbusInterface;

class RecordDeployment
{
    public function __construct(
        private readonly DeploymentRepositoryInterface $repository,
        private readonly EventbusInterface $eventbus
    ) {
    }

    public function __invoke(
        DeploymentTime $deploymentTime,
        RepositoryName $repositoryName,
        Author $author,
        ReleaseId $releaseId,
        ReleaseName $releaseName
    ): void {
        $deployment = Deployment::create(
            $deploymentTime,
            $repositoryName,
            $author,
            $releaseId,
            $releaseName
        );

        $this->repository->save($deployment);

        $this->eventbus->publish(...$deployment->fetchEvents());
    }
}
