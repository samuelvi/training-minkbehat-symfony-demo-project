<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Subscription as SubscriptionEntity;
use AppBundle\Model\ContactDetail as ContactDetailModel;
use AppBundle\Service\Subscription as SubscriptionService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use AppBundle\Event\ContactFormEvent;
use AppBundle\Event\ContactFormEvents;

class CreateSubscriptionFromContactFormListener implements EventSubscriberInterface
{
    /** @var SubscriptionService */
    private $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public static function getSubscribedEvents()
    {
        return array(
            ContactFormEvents::NEW_CONTACTFORM_REQUESTED => 'onNewContactForm'
        );
    }

    public function onNewContactForm(ContactFormEvent $event)
    {
        /** @var ContactDetailModel $contactDetailModel */
        $contactDetailModel = $event->getContactDetail();

        if ($contactDetailModel->getNewsletter() == 1) {
            if (!$this->subscriptionService->existsSubscriptionByEmail($contactDetailModel->getEmail())) {
                $this->subscriptionService->createSubscriptionFromContactDetails($contactDetailModel);
            }
        }
    }

}