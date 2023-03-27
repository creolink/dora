<?php

namespace App\Domains\DeploymentFrequency\Domain;

use App\Domains\DeploymentFrequency\Domain\Events\DeploymentExecuted;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentId;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentTimeValueObject;
use App\Shared\Domain\AggregateRoot;

final class Deployment extends AggregateRoot
{
    public function __construct(
        private readonly DeploymentId              $deploymentId,
        private readonly DeploymentTimeValueObject $deploymentTime,
        private readonly string                    $repositoryName,
        private readonly string                    $author,
        private readonly string                    $releaseId,
        private readonly string                    $releaseName
    ) {
    }

    public static function create(
        DeploymentTimeValueObject $deploymentTime,
        string                    $repository,
        string                    $author,
        string                    $releaseId,
        string                    $releaseName
    ): self {
        $deployment = new self(
            DeploymentId::init(),
            $deploymentTime,
            $repository,
            $author,
            $releaseId,
            $releaseName
        );

        $deployment->recordEvent(new DeploymentExecuted($deployment));

        return $deployment;
    }

    public function publish()
    {
        $this->recordEvent(new DeploymentExecuted($this));
    }

    public function getDeploymentId(): DeploymentId
    {
        return $this->deploymentId;
    }

    public function getDeploymentTime(): DeploymentTimeValueObject
    {
        return $this->deploymentTime;
    }

    public function getRepositoryName(): string
    {
        return $this->repositoryName;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getReleaseId(): string
    {
        return $this->releaseId;
    }

    public function getReleaseName(): string
    {
        return $this->releaseName;
    }
}