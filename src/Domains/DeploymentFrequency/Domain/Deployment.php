<?php

namespace App\Domains\DeploymentFrequency\Domain;

use App\Domains\DeploymentFrequency\Domain\Events\CodeDeployed;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentId;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentTime;
use App\Shared\Domain\AggregateRoot;

final class Deployment extends AggregateRoot
{
    public function __construct(private readonly DeploymentId $deploymentId,
                                private readonly DeploymentTime $deploymentTime,
                                private readonly string $repository,
                                private readonly string $authorEmail,
                                private readonly string $releaseName
    ) {
    }

    public static function create(DeploymentTime $deploymentTime, string $repository, string $authorEmail, string $releaseName): self
    {
        $deployment = new self(
            DeploymentId::init(),
            $deploymentTime,
            $repository,
            $authorEmail,
            $releaseName
        );

        $deployment->store(new CodeDeployed($deployment));

        return $deployment;
    }

    public function getDeploymentId(): DeploymentId
    {
        return $this->deploymentId;
    }

    public function getDeploymentTime(): DeploymentTime
    {
        return $this->deploymentTime;
    }

    public function getRepository(): string
    {
        return $this->repository;
    }

    public function getAuthorEmail(): string
    {
        return $this->authorEmail;
    }

    public function getReleaseName(): string
    {
        return $this->releaseName;
    }
}