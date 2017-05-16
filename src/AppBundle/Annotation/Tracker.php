<?php

namespace AppBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;


/**
 * @Annotation
 * @Attributes({
 *   @Attribute("subject", type="string", required=true),
 * })
 */
class Tracker
{
    /** @var string $subject */
    public $subject;

    /** @return string */
    public function getSubject()
    {
        return $this->subject;
    }
}
