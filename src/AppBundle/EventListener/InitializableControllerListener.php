<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use AppBundle\Controller\InitializableControllerInterface;


class InitializableControllerListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
            // not a object but a different kind of callable. Do nothing
            return;
        }

        $controllerObject = $controller[0];
        if ($controllerObject instanceof InitializableControllerInterface) {
            $controllerObject->__init($event->getRequest());
        }
    }

}