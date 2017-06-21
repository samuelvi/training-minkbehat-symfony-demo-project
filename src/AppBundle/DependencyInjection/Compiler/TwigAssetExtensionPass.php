<?php

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use AppBundle\Twig\Extension\AssetExtension;

class TwigAssetExtensionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
      if (false === $container->hasDefinition('twig.extension.assets')) {
          return;
      }

      $definition = $container->getDefinition('twig.extension.assets');
      $definition->setClass(AssetExtension::class);
    }
}