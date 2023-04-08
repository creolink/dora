<?php

namespace App\Domains\DeploymentFrequency\Domain;

use App\Domains\DeploymentFrequency\Domain\Events\DeploymentAcknowledged;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentId;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentDateTime;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\ReleaseId;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\ReleaseName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Shared\Domain\AggregateRoot;

final class Deployment extends AggregateRoot
{
    private function __construct(
        private readonly DeploymentId $deploymentId,
        private readonly DeploymentDateTime $deploymentTime,
        private readonly RepositoryName $repositoryName,
        private readonly Author $author,
        private readonly ReleaseId $releaseId,
        private readonly ReleaseName $releaseName
    ) {
    }

    public static function create(
        DeploymentDateTime $deploymentTime,
        RepositoryName $repositoryName,
        Author $author,
        ReleaseId $releaseId,
        ReleaseName $releaseName
    ): self {
        $deployment = new self(
            DeploymentId::generate(),
            $deploymentTime,
            $repositoryName,
            $author,
            $releaseId,
            $releaseName
        );

        $deployment->recordEvent(new DeploymentAcknowledged($deployment));

        return $deployment;
    }

    public function publish()
    {
        $this->recordEvent(new DeploymentAcknowledged($this));
    }

    public function getDeploymentId(): DeploymentId
    {
        return $this->deploymentId;
    }

    public function getDeploymentTime(): DeploymentDateTime
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
