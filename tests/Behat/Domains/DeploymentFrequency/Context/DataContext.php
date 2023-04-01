<?php

namespace App\Tests\Behat\Domains\DeploymentFrequency\Context;

use Behat\Behat\Context\Context;

class DataContext extends AbstractContext implements Context
{
    /**
     * @BeforeScenario @initData
     */
    public function initData()
    {
        $this->deploymentRepository->initData();
    }
}