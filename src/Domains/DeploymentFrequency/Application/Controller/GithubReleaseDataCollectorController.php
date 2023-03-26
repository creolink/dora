<?php

declare(strict_types=1);

namespace App\Domains\DeploymentFrequency\Application\Controller;

use App\Domains\DeploymentFrequency\Domain\Deployment;
use App\Domains\DeploymentFrequency\Domain\DeploymentRepositoryInterface;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentTime;
use App\Shared\EventBus\Eventbus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GithubReleaseDataCollectorController extends AbstractController
{
    public function __construct(
        private readonly DeploymentRepositoryInterface $repository,
        private readonly Eventbus $eventbus
    ) {
    }

    #[Route('/payload', name: 'release_payload')]
    public function collectStat(Request $request): JsonResponse
    {
        $repository = $request->request->get('repository');
        $releaseData = $request->request->get('release');
        $deploymentTime = DeploymentTime::fromString($releaseData->published_at);
        $authorEmail = $releaseData->author->email;
        $releaseName = $releaseData->name;

        $deployment = Deployment::create(
            $deploymentTime, $repository, $authorEmail, $releaseName
        );

        return new JsonResponse($repository);
    }
}