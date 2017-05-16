<?php

namespace AppBundle\Validator\Constraints\Subscription;

use AppBundle\Entity\Subscription as SubscriptionEntity;
use AppBundle\Service\Subscription as SubscriptionService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class EmailUniqueValidator extends ConstraintValidator
{
    /** @var SubscriptionService $subscriptionService */
    private $subscriptionService;

    public function __construct($subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function validate($value, Constraint $constraint)
    {
        $email = $this->context->getRoot()->getViewData()->getEmail();

        /** @var SubscriptionEntity $subscriptionEntity */
        $subscriptionEntity = $this->subscriptionService->getSubscriptionByEmail($email);

        if ($subscriptionEntity !== null) {
            $this->context->buildViolation(sprintf('The e-mail "%s" is already subscribed', $email))
                ->atPath('property')
                ->addViolation();
        }
    }
}