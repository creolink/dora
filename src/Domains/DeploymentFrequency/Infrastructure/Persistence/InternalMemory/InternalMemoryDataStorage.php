<?php

namespace App\Domains\DeploymentFrequency\Infrastructure\Persistence\InternalMemory;

class InternalMemoryDataStorage
{
    protected static MemoryStorageCollection $memory;

    public function __construct()
    {
        if (!isset(static::$memory)) {
            $this->initData();
        }
    }

    public function initData(): void
    {
        static::$memory = new MemoryStorageCollection();
    }
}
