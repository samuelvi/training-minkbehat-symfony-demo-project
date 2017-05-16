<?php

namespace AppBundle\Controller;

use AppBundle\Service\LastPage as LastPageService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LastPageController extends Controller
{
    /**
     * @Route("/last-page-ok/{parameters}", name="last_page_ok", requirements={"parameters" = ".*"}, defaults={"parameters" = ""})
     * @return Response
     */
    public function okAction($parameters)
    {
        $parameters = LastPageService::decodeParameters($parameters);
        return $this->render(':last_page:last_page_ok.html.twig', $parameters);
    }

}
