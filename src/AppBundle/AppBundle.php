<?php

namespace AppBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

<<<<<<< HEAD
use AppBundle\DependencyInjection\Compiler\DevAssetVersionStrategyPass;
=======
use AppBundle\DependencyInjection\Compiler\TwigAssetExtensionPass;
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b

class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
<<<<<<< HEAD
        $container->addCompilerPass(new DevAssetVersionStrategyPass());
=======
        $container->addCompilerPass(new TwigAssetExtensionPass());
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
    }
}
