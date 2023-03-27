<?php

namespace App\Domains\DeploymentFrequency\Application;

use App\Shared\Domain\Bus\Command\CommandInterface;

class RecordDeploymentCommand implements CommandInterface
{
    public function __construct(
        private readonly string $deploymentTime,
        private readonly string $repositoryName,
        private readonly string $author,
        private readonly string $releaseId,
        private readonly string $releaseName
    ) {
    }

    public function getDeploymentTime(): string
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