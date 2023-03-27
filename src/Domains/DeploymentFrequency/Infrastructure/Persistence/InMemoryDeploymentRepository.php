<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence;

use App\Domains\DeploymentFrequency\Domain\Deployment;
use App\Domains\DeploymentFrequency\Domain\DeploymentRepositoryInterface;

class InMemoryDeploymentRepository implements DeploymentRepositoryInterface
{
    private static array $deployments = [];

    public function save(Deployment $deployment): void
    {
        self::$deployments[$deployment->getDeploymentId()->get()] = $deployment;

        dump('SAVED IN MEMORY');
    }
}