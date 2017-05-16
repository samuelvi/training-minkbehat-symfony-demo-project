<?php

namespace AppBundle\Service;

use AppBundle\Model\ContactDetail as ContactDetailModel;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Subscription as SubscriptionEntity;

class Subscription
{
    /** @var EntityManager $em */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNumberOfSubscriptions()
    {
        return $this->em->getRepository('AppBundle:Subscription')->getNumberOfSubscriptions();
    }

    public function getSubscriptionById($id)
    {
        return $this->em->getRepository('AppBundle:Subscription')->find($id);
    }

    public function getSubscriptionByEmail($email)
    {
        return $this->em->getRepository('AppBundle:Subscription')->findOneByEmail($email);
    }

    public function getAllSubscriptionsByEmailAndFullName($email, $fullName)
    {
        $params = array('email' => $email, 'fullname' => $fullName);
        return $this->em->getRepository('AppBundle:Subscription')->findBy($params);
    }

    public function createSubscriptionFromContactDetails(ContactDetailModel $contactDetailModel)
    {
        $subscriptionEntity = SubscriptionEntity::createFromContactDetail($contactDetailModel);
        $this->em->persist($subscriptionEntity);
        $this->em->flush();
    }

    public function existsSubscriptionByEmail($email)
    {
        return (null !== $this->getSubscriptionByEmail($email));
    }
}