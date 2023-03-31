<?php

namespace App\Domains\DeploymentFrequency\Domain;

use App\Domains\DeploymentFrequency\Domain\Events\DeploymentExecuted;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentId;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentTime;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\ReleaseId;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\ReleaseName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Shared\Domain\AggregateRoot;

final class Deployment extends AggregateRoot
{
    public function __construct(
        private readonly DeploymentId $deploymentId,
        private readonly DeploymentTime $deploymentTime,
        private readonly RepositoryName $repositoryName,
        private readonly Author $author,
        private readonly ReleaseId $releaseId,
        private readonly ReleaseName $releaseName
    ) {
    }

    public static function create(
        DeploymentTime $deploymentTime,
        RepositoryName $repositoryName,
        Author $author,
        ReleaseId $releaseId,
        ReleaseName $releaseName
    ): self {
        $deployment = new self(
            DeploymentId::init(),
            $deploymentTime,
            $repositoryName,
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

    public function getDeploymentTime(): DeploymentTime
    {
        return $this->deploymentTime;
    }

    public function getRepositoryName(): RepositoryName
    {
        return $this->repositoryName;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getReleaseId(): ReleaseId
    {
        return $this->releaseId;
    }

    public function getReleaseName(): ReleaseName
    {
        return $this->releaseName;
    }
}
