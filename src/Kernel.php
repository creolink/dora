<?php

namespace App;

use App\DependencyInjection\Compiler\TaggedIteratorToSeparateArgumentsPass;
use App\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TaggedIteratorToSeparateArgumentsPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
