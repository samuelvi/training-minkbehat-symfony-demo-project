<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

interface InitializableControllerInterface
{
    public function __init(Request $request);
}