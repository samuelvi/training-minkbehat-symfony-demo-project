<?php

# bin/console doctrine:fixtures:load --fixtures=src/AppBundle/DataFixtures/ORM/LoadProductData.php --env=test

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadProductData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface $container */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $loader = new \Nelmio\Alice\Fixtures\Loader('es_ES', array($this, ['category_name']));

        $dataFixtureFiles = array(
            __DIR__.'/category.yml',
            __DIR__.'/product.yml',
        );

        $persister = new \Nelmio\Alice\Persister\Doctrine($manager);
        foreach ($dataFixtureFiles as $dataFixtureFile) {
            $persister->persist($loader->load($dataFixtureFile));
        }
    }

    public function category_name($name)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        return $em->getRepository('AppBundle:Category')->findOneBy(['name' => $name]);
    }

    public function getOrder()
    {
        return 20;
    }
}