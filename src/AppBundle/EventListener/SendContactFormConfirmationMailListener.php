<?php

namespace AppBundle\EventListener;

use AppBundle\Event\ContactFormEvent;
use AppBundle\Event\ContactFormEvents;

use AppBundle\Model\ContactDetail as ContactDetailModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use AppBundle\Service\Mailer as MailerService;


class SendContactFormConfirmationMailListener implements EventSubscriberInterface
{
    /** @var MailerService $mailerService */
    private $mailerService;

    /** @var string $webmasterMailerUser */
    private $webmasterMailerUser;

    public function __construct(MailerService $mailerService, $webmasterMailerUser)
    {
        $this->mailerService = $mailerService;
        $this->webmasterMailerUser = $webmasterMailerUser;
    }

    private function sendConfirmationMessage(ContactDetailModel $contactDetail)
    {
        $this->sendEmailToRequester($contactDetail);
        $this->sendEmailToWebmaster($contactDetail);
    }

    protected function buildBody(ContactDetailModel $contactDetail)
    {
        $body = 'This is copy of your contact form:';
        $body .= sprintf('Name: %s%s', $contactDetail->getFullname(), PHP_EOL);
        $body .= sprintf('Subject: %s%s', $contactDetail->getSubject(), PHP_EOL);
        $body .= sprintf('Message: %s%s', $contactDetail->getMessage(), PHP_EOL);
        return $body;
    }

    protected function sendEmailToRequester(ContactDetailModel $contactDetail)
    {
        $subject = sprintf('Thank you %s for contacting Us!', $contactDetail->getFullname());
        $to = $contactDetail->getEmail();
        $body = $this->buildBody($contactDetail);
        $this->mailerService->sendEmail(null, $to, $subject, $body);
    }

    protected function sendEmailToWebmaster(ContactDetailModel $contactDetail)
    {
        $subject = sprintf('A user contacted Us! (%s)', $contactDetail->getFullname());
        $to = $this->webmasterMailerUser;
        $body = $this->buildBody($contactDetail);
        $this->mailerService->sendEmail(null, $to, $subject, $body);
    }

    public static function getSubscribedEvents()
    {
        return array(
            ContactFormEvents::NEW_CONTACTFORM_REQUESTED => 'onNewContactForm'
        );
    }

    public function onNewContactForm(ContactFormEvent $event)
    {
        $this->sendConfirmationMessage($event->getContactDetail());
    }

}