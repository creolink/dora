<?php

namespace App\Tests\Behat\Domains\DeploymentFrequency\Context;

use App\Domains\DeploymentFrequency\Domain\DeploymentRepositoryInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Psr\Container\ContainerInterface;

class AbstractContext
{
    public DeploymentRepositoryInterface $deploymentRepository;

    protected KernelInterface $kernel;
    protected ContainerInterface $container;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->container = $this->kernel->getContainer()->get('test.service_container');

        $this->deploymentRepository = $this->container->get(DeploymentRepositoryInterface::class);
    }
}