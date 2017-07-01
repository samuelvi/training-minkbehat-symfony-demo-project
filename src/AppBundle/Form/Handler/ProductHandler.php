<?php

namespace AppBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ProductHandler
{
    /** @var Request $request */
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function handle(Request $request)
    {
        if (!$request->isMethod('GET')) {
            return array();
        }

        // Filter Parameters
    }
}