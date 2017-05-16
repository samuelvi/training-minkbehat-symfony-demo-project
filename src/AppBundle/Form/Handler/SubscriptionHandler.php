<?php

namespace AppBundle\Form\Handler;

use AppBundle\DomainManager\SubscriptionManager;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionHandler
{
    /** @var SubscriptionManager $subscriptionManager */
    private $subscriptionManager;

    public function __construct(SubscriptionManager $subscriptionManager)
    {
        $this->subscriptionManager = $subscriptionManager;
    }

    public function handle(FormInterface $form, Request $request)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->handleRequest($request);
        if (!$form->isValid()) {
            $form->addError(new FormError('The subscription could not be created'));
            return false;
        }

        $validSubscription = $form->getData();
        $this->subscriptionManager->createSubscription($validSubscription);
        return true;
    }
}