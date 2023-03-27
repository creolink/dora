<?php

namespace App\Domains\DeploymentFrequency\Application;

use App\Domains\DeploymentFrequency\Domain\Deployment;
use App\Domains\DeploymentFrequency\Domain\DeploymentRepositoryInterface;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentTimeValueObject;
use App\Shared\Domain\Bus\Event\EventbusInterface;

class RecordDeployment
{
    public function __construct(
        private readonly DeploymentRepositoryInterface $repository,
        private readonly EventbusInterface $eventbus
    ) {
    }

    public function __invoke(
        DeploymentTimeValueObject $deploymentTime,
        string $repositoryName,
        string $author,
        string $releaseId,
        string $releaseName
    ): void {
        $deployment = Deployment::create(
            $deploymentTime,
            $repositoryName,
            $author,
            $releaseId,
            $releaseName
        );

        $this->repository->save($deployment);
        $this->eventbus->publish($deployment->fetchEvents());
    }
}