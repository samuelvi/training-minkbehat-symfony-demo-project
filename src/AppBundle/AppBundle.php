<?php

namespace AppBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use AppBundle\DependencyInjection\Compiler\DevAssetVersionStrategyPass;

class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new DevAssetVersionStrategyPass());
    }
}
