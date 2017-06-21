<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LegalController extends Controller
{
    /**
     * @Route("/cookies", name="legal_cookies")
     */
    public function cookiesAction()
    {
        return $this->render('legal/cookies.html.twig');
    }

    /**
     * @Route("/terms-and-conditions", name="legal_terms_and_conditions")
     */
    public function termsAndConditionsAction()
    {
        return $this->render('legal/terms_and_conditions.html.twig');
    }
}
