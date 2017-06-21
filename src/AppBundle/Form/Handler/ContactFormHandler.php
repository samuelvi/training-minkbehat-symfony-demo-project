<?php

namespace AppBundle\Form\Handler;

use AppBundle\DomainManager\ContactFormManager;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ContactFormHandler
{
    /** @var ContactFormManager $contactFormManager */
    private $contactFormManager;

    public function __construct(ContactFormManager $contactFormManager)
    {
        $this->contactFormManager = $contactFormManager;
    }

    public function handle(FormInterface $form, Request $request)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->handleRequest($request);
        if (!$form->isValid()) {
            $form->addError(new FormError('The contact form could not be submitted'));
            return false;
        }

        $this->contactFormManager->submitContactForm($form->getData());
        return true;
    }
}