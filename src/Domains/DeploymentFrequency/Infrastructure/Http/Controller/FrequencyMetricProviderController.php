<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Http\Controller;

use App\Domains\DeploymentFrequency\Application\FrequencyMetricProvider;
use App\Domains\DeploymentFrequency\Application\FrequencyMetricQuery;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\TimeRangeInDays;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FrequencyMetricProviderController extends AbstractController
{
    public function __construct(private readonly FrequencyMetricProvider $frequencyMetric)
    {
    }

    #[Route('/metric/{repositoryName}', name: 'frequency_metric', methods: 'GET')]
    public function provideFrequencyMetric(Request $request): JsonResponse
    {
        $repositoryName = RepositoryName::toValue($request->get('repositoryName'));
        $timeRangeInDays = TimeRangeInDays::toInt($request->get('timeRangeDays'));

        $metric = $this->frequencyMetric->__invoke(
            new FrequencyMetricQuery(
                $repositoryName,
                $timeRangeInDays,
                null
            )
        );

        return new JsonResponse($metric->toResponse());
    }
}
