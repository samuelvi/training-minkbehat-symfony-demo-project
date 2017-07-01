<?php

namespace AppBundle\Validator\Constraints\Subscription;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EmailUnique extends Constraint
{
    public $message = 'Already existing e-mail';

    public function getTargets()
    {
        return array(self::CLASS_CONSTRAINT, self::PROPERTY_CONSTRAINT);
    }

    public function validatedBy()
    {
        return 'subscription_email_unique';
    }
}