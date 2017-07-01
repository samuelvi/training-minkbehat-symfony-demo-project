<?php

namespace AppBundle\DomainManager;

use AppBundle\Event\SubscriptionEvent;
use AppBundle\Event\SubscriptionEvents;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Subscription as SubscriptionEntity;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SubscriptionManager
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /** @var  EventDispatcherInterface $eventDispatcher */
    private $eventDispatcher;

    public function __construct(EntityManager $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @SendSubscriptionConfirmationEmail
     */
    public function createSubscription(SubscriptionEntity $subscription)
    {
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(SubscriptionEvents::NEW_SUBSCRIPTION_CREATED, new SubscriptionEvent($subscription));
    }
}