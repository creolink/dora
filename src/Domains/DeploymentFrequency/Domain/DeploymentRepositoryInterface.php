<?php

namespace App\Domains\DeploymentFrequency\Domain;

interface DeploymentRepositoryInterface
{
    public function save(): void;
}