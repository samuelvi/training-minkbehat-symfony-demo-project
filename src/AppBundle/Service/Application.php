<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class Application
{
    /** @var  TokenStorageInterface $securityTokenStorage */
    protected $securityTokenStorage;

    public function __construct($securityTokenStorage)
    {
        $this->securityTokenStorage = $securityTokenStorage;
    }

    public function getUser()
    {
        // no authentication information is available
        /** @var TokenInterface $token */
        if (null === $token = $this->securityTokenStorage->getToken()) {
            return null;
        }

        // e.g. anonymous authentication
        if ((!$user = $token->getUser()) instanceof User) {
            return null;
        }

        return $user;
    }
}