<?php

namespace App\Domains\DeploymentFrequency\Application;

use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentDateTime;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\ReleaseId;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\ReleaseName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RecordDeploymentCommandHandler implements CommandHandlerInterface, EventSubscriberInterface
{
    public function __construct(
        private readonly RecordDeployment $metricSaver
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            RecordDeploymentCommand::class => '__invoke',
        ];
    }

    public function __invoke(RecordDeploymentCommand $command)
    {
        $this->metricSaver->__invoke(
            DeploymentDateTime::fromString($command->getDeploymentTime()),
            RepositoryName::toString($command->getRepositoryName()),
            Author::toString($command->getAuthor()),
            ReleaseId::toString($command->getReleaseId()),
            ReleaseName::toString($command->getReleaseName())
        );
    }
}
