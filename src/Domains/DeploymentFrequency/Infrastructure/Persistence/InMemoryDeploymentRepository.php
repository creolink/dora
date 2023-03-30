<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence;

use App\Domains\DeploymentFrequency\Domain\Deployment;
use App\Domains\DeploymentFrequency\Domain\DeploymentRepositoryInterface;
use App\Domains\DeploymentFrequency\Infrastructure\Persistence\InternalMemory\InternalMemoryDataStorage;
use App\Domains\DeploymentFrequency\Infrastructure\Persistence\InternalMemory\MemoryStorageCollection;

class InMemoryDeploymentRepository extends InternalMemoryDataStorage implements DeploymentRepositoryInterface
{
    public function save(Deployment $deployment): void
    {
        self::$memory->add($deployment);

        dump('SAVED IN MEMORY');
    }
}