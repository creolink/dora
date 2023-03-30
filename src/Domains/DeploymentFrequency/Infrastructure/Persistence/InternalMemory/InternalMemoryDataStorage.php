<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence\InternalMemory;

class InternalMemoryDataStorage
{
    protected static array $deployments = [];
    protected static MemoryStorageCollection $memory;

    public function __construct()
    {
        self::$memory = new MemoryStorageCollection();
    }
}