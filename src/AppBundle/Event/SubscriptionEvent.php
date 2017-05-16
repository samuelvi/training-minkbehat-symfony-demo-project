<?php

namespace AppBundle\Event;

use AppBundle\Entity\Subscription as SubscriptionEntity;
use Symfony\Component\EventDispatcher\Event;

class SubscriptionEvent extends Event
{
    /** @var SubscriptionEntity $subscription */
    private $subscription;

    public function __construct(SubscriptionEntity $subscription) {
        $this->subscription = $subscription;
    }
    public function getSubscription() {
        return $this->subscription;
    }
}