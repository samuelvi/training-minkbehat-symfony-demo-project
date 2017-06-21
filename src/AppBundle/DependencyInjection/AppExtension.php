<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

class AppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
<<<<<<< HEAD
        $this->doProcessConfiguration($configs);
        $this->loadServices($container);
    }

    private function loadServices(ContainerBuilder $container)
    {
=======
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
        if (is_file(__DIR__ . '/../Resources/config/services.yml')) {
            $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
            $loader->load('services.yml');
        } else if (is_file(__DIR__ . '/../Resources/config/services.xml')) {
            $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
<<<<<<< HEAD
            $loader->load('services.xml');
        }
    }

    private function doProcessConfiguration(array $configs)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);
    }

=======
            $loader->load('services.yml');
        }
    }
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
}
