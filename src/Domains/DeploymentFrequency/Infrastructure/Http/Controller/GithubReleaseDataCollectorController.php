<?php

declare(strict_types=1);

namespace App\Domains\DeploymentFrequency\Infrastructure\Http\Controller;

use App\Domains\DeploymentFrequency\Application\RecordDeploymentCommand;
use App\Domains\DeploymentFrequency\Application\RecordDeploymentCommandHandler;
use App\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GithubReleaseDataCollectorController extends AbstractController
{
    public function __construct(
        private readonly RecordDeploymentCommandHandler $commandHandler,
        private readonly CommandBusInterface            $commandBus
    ) {
    }

    #[Route('/payload', name: 'release_payload')]
    public function collectStat(Request $request): Response
    {
        $releaseData = $request->get('release');
        $repositoryData = $request->get('repository');

        $deployReleaseCommand = new RecordDeploymentCommand(
            $releaseData['published_at'],
            $repositoryData['name'],
            $releaseData['author']['login'],
            (string) $releaseData['id'],
            $releaseData['name']
        );

        $this->commandBus->dispatch($deployReleaseCommand);

        return new Response('', Response::HTTP_CREATED);
    }
}