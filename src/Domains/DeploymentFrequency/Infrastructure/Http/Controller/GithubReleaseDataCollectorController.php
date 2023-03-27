<?php

declare(strict_types=1);

namespace App\Domains\DeploymentFrequency\Infrastructure\Http\Controller;

use App\Domains\DeploymentFrequency\Application\RecordDeploymentCommand;
use App\Domains\DeploymentFrequency\Application\RecordDeploymentCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GithubReleaseDataCollectorController extends AbstractController
{
    public function __construct(
        private readonly RecordDeploymentCommandHandler $commandHandler
    ) {
    }

    #[Route('/payload', name: 'release_payload')]
    public function collectStat(Request $request): JsonResponse
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

        $this->commandHandler->__invoke($deployReleaseCommand);

        return new JsonResponse($releaseData);
    }
}