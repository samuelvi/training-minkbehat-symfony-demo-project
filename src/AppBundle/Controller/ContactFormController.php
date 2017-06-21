<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactFormType;

use AppBundle\Service\LastPage as LastPageService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Model\ContactDetail as ContactDetailModel;

class ContactFormController extends Controller
{
    /**
     * @Route("/contact", name="contact_form")
     * @return Response
     */
    public function contactAction(Request $request)
    {
        $contactDetail = ContactDetailModel::createFromUser($this->getUser());
        $form = $this->createForm(ContactFormType::class, $contactDetail);

        $formHandler = $this->container->get('app.form_handler.contact_form_handler');
        $formHandler->handle($form, $request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $parameters = $this->buildContactOkParameters();
                return $this->redirectToRoute('last_page_ok', array('parameters' => LastPageService::encodeParameters($parameters)));
            }
        }
        return $this->render(':contact:index.html.twig', array('form' => $form->createView()));
    }

    /** @return array */
    protected function buildContactOkParameters()
    {
        $parameters = array(
            'response' => 'OK',
            'flashbag' => array(
                'success' => 'Your messages was managed successfully',
            ),
            'title' => 'You are here: Contact Form Submission',
            'messages' => array('Your messages has been properly managed', 'Please check your inbox', 'If your didn\'t receive any e-mail, please check your SPAM folder.'),
            'footer' => 'Thank you for using our services!',
        );
        return $parameters;
    }

}
