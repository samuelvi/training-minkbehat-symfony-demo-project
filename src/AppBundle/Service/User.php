<?php

namespace AppBundle\Service;

use AppBundle\Entity\User as UserEntity;
use FOS\UserBundle\Model\UserManagerInterface;

class User
{
    /** @var  UserManagerInterface $fosUserManager */
    protected  $fosUserManager;

    public function __construct(UserManagerInterface $fosUserManager)
    {
        $this->fosUserManager = $fosUserManager;
    }

    public function createUserFromCommandLine($userName, $password, $email, $firstName, $lastName, $active, $superadmin)
    {
        $userEntity = new UserEntity();
        $userEntity->setUsername($userName);
        $userEntity->setEmail($email);
        $userEntity->setFirstName($firstName);
        $userEntity->setLastName($lastName);
        $userEntity->setPlainPassword($password);
        $userEntity->setEnabled((Boolean)$active);
        $userEntity->setSuperAdmin((Boolean)$superadmin);

        $this->fosUserManager->updateUser($userEntity);
        return $userEntity;
    }
}