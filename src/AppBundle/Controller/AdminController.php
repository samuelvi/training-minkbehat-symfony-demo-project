<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    /** @var array The full configuration of the entire backend */
    protected $config;

    /** @var array The full configuration of the current entity */
    protected $entity;

    /** @var Request The instance of the current Symfony request */
    protected $request;

    /** @var EntityManager The Doctrine entity manager for the current entity */
    protected $em;

    public function prePersistEntity($entity)
    {
        if (method_exists($entity, 'setCreatedAt')) {
            if ($entity->getCreatedAt() == null) {
                $entity->setCreatedAt(new \DateTime());
            }
        }
    }
}
