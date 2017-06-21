<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Annotation\Tracker;
use AppBundle\Form\SubscriptionType;
use AppBundle\Entity\Subscription as SubscriptionEntity;

class SubscriptionController extends Controller
{
    /**
     * @Route("/subscription/add", name="subscription_add")
     * @Tracker(subject="New Subscription")
     * @return Response|JsonResponse
     */
    public function addAction(Request $request)
    {
<<<<<<< HEAD

=======
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
        $subscriptionEntity = new SubscriptionEntity();
        $form = $this->createForm(SubscriptionType::class, $subscriptionEntity);

        $formHandler = $this->container->get('app.form_handler.subscription_handler');
        $formHandler->handle($form, $request);

        if ($form->isSubmitted() && $request->isXmlHttpRequest()) {
            if ($form->isValid()) {
                $response = array(
                    'response' => array(
                        'state' => 'OK',
                        'view' => $this->renderView('subscription/subscription_ok.html.twig'),
                    )
                );
            } else {
                // Build Error Response
                $response = array(
                    'response' => array(
                        'state' => 'ERROR',
                        'view' => $this->renderView('subscription/subscription_form.html.twig',
                            array('form' => $form->createView())
                        ),
                    )
                );
            }
            return new JsonResponse($response);
        } else {
            return $this->render(':subscription:subscription_form.html.twig', array('form' => $form->createView()));
        }
    }
}
