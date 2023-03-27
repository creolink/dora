<?php

namespace App\Domains\DeploymentFrequency\Application;

use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentTimeValueObject;
use App\Shared\Domain\Bus\Command\CommandHandlerInterface;

class RecordDeploymentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RecordDeployment $metricSaver
    ) {
    }

    public function __invoke(RecordDeploymentCommand $command)
    {
        $this->metricSaver->__invoke(
            DeploymentTimeValueObject::fromString($command->getDeploymentTime()),
            $command->getRepositoryName(),
            $command->getAuthor(),
            $command->getReleaseId(),
            $command->getReleaseName()
        );
    }
}