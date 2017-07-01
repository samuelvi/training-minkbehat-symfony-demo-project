<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Service\User as UserService;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface $container */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        if ($this->container == null ) return;
        /** @var UserService $userService */
        $userService = $this->container->get('app.service.user');
        $userService->createUserFromCommandLine('admin', 'admin', 'admin@minkbehat.com', 'First Name', 'Last Name', true, true);
    }

    public function getOrder()
    {
        return 10;
    }
}