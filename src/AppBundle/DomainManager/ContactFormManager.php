<?php

namespace AppBundle\DomainManager;

use AppBundle\Event\ContactFormEvent;
use AppBundle\Event\ContactFormEvents;
use AppBundle\Model\ContactDetail;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ContactFormManager
{
    /** @var  EventDispatcherInterface $eventDispatcher */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @SendSubscriptionConfirmationEmail
     */
    public function submitContactForm(ContactDetail $contactDetail)
    {
        $this->eventDispatcher->dispatch(ContactFormEvents::NEW_CONTACTFORM_REQUESTED, new ContactFormEvent($contactDetail));
    }
}