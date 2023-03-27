<?php

namespace App\Domains\DeploymentFrequency\Infrastructure;

use App\Domains\DeploymentFrequency\Domain\DeploymentRepositoryInterface;

class DeploymentRepository implements DeploymentRepositoryInterface
{
    public function save(): void
    {
        dump('SAVED');
    }
}