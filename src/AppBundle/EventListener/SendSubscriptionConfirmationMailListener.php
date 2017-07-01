<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Subscription as SubscriptionEntity;
use AppBundle\Event\SubscriptionEvent;
use AppBundle\Event\SubscriptionEvents;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use AppBundle\Service\Mailer as MailerService;


class SendSubscriptionConfirmationMailListener implements EventSubscriberInterface
{
    /** @var MailerService $mailerService */
    private $mailerService;

    public function __construct(MailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    private function sendConfirmationMessage(SubscriptionEntity $subscription)
    {
        $subject = 'Confirm Subscription';
        $body = 'This is a Subscription Confirmation e-mail!';
        $to = $subscription->getEmail();
        $this->mailerService->sendEmail(null, $to, $subject, $body);
    }

    public static function getSubscribedEvents()
    {
        return array(
            SubscriptionEvents::NEW_SUBSCRIPTION_CREATED => 'onNewSubscription'
        );
    }

    public function onNewSubscription(SubscriptionEvent $event)
    {
        $this->sendConfirmationMessage($event->getSubscription());
    }

}