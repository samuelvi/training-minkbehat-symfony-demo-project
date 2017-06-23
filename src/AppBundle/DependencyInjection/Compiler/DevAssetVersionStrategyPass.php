<?php

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use AppBundle\Asset\DevVersionStrategy;

class DevAssetVersionStrategyPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $this->processEmptVersionStrategy($container);
    }

    public function processEmptVersionStrategy(ContainerBuilder $container)
    {
        $app = $container->getExtensionConfig('app')[0];

        if (isset($app['dev_version_strategy']) && $app['dev_version_strategy']) {

            if (false === $container->hasDefinition('assets.empty_version_strategy')) {
                return;
            }

            $definition = $container->getDefinition('assets.empty_version_strategy');
            $definition->setClass(DevVersionStrategy::class);
        }
    }
}