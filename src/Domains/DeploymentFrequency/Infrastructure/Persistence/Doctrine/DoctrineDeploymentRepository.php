<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence\Doctrine;

use App\Domains\DeploymentFrequency\Domain\Deployment;
use App\Domains\DeploymentFrequency\Domain\DeploymentRepositoryInterface;

class DoctrineDeploymentRepository implements DeploymentRepositoryInterface
{
    public function save(Deployment $deployment): void
    {
        dump('SAVED IN DB Doctrine');
    }
}