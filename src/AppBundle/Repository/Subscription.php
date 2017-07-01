<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class Subscription extends EntityRepository
{
    public function getNumberOfSubscriptions()
    {
        $qb = $this->createQueryBuilder('number_of_subscriptions');
        $qb->select('count(number_of_subscriptions)');
        return $qb->getQuery()->getSingleScalarResult();
    }
}