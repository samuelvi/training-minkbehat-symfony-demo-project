<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Subscription as SubscriptionEntity;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class CreateSubscriptionEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array('prePersist');
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();
        if (!($entity instanceof SubscriptionEntity)) {
            return;
        }
        $this->createSubscription($entity);
    }

    private function createSubscription(SubscriptionEntity $subscriptionEntity)
    {
        $subscriptionEntity->setCreatedAt(new \DateTime());
    }
}