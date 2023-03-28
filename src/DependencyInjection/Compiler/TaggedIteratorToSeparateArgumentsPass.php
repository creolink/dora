<?php

declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TaggedIteratorToSeparateArgumentsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getDefinitions() as $definition) {
            if (!$definition->hasTag('tagged_iterator_to_array')) {
                continue;
            }

            $arguments = $definition->getArguments();

            $lastArgument = end($arguments);
            if ($lastArgument instanceof TaggedIteratorArgument) {
                array_pop($arguments);
                foreach ($lastArgument->getValues() as $value) {
                    $arguments[] = $value;
                }

                $definition->setArguments($arguments);
            }
        }
    }
}
