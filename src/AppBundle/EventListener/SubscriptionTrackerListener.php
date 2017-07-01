<?php

namespace AppBundle\EventListener;

use AppBundle\Annotation\Tracker as TrackerAnnotation;
use AppBundle\Monolog\MonologManager;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class SubscriptionTrackerListener extends AbstractControllerAnnotationListener
{
    /** @var  Reader $annotationReader */
    private $annotationReader;

    /** @var MonologManager $logger*/
    private $logger;

    public function __construct(Reader $annotationReader, MonologManager $logger)
    {
        $this->annotationReader = $annotationReader;
        $this->logger = $logger;
    }

    protected function getAnnotationClass()
    {
        return 'AppBundle\Annotation\Tracker';
    }

    /**
     * @param TrackerAnnotation $annotation
     * @param FilterControllerEvent $event
     */
    protected function processAnnotation($annotation, FilterControllerEvent $event)
    {
        $subject = $annotation->getSubject();
        $email = $event->getRequest()->request->get('subscription_type')['email'];

        if ($email !== null) {
            $this->logger->info($subject, array('email' => $email));
        }
    }
}