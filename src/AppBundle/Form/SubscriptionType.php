<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormError;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email', TextType::class,
            array(
                'label'     => false,
                'required'  => true,
            )
        );

        $builder->add(
            'fullname', TextType::class,
            array(
                'label'     => false,
                'required'  => true,
            )
        );

        $builder->add(
            'legal', CheckboxType::class,
            array(
                'label' => 'Accept terms and conditions *',
                'required' => true,
                'mapped' => false,
            )
        );

        $builder->addEventListener(FormEvents::POST_SUBMIT, array($this, 'onPostSubmit'));
    }

    public function onPostSubmit(FormEvent $event)
    {
        /** @var FormInterface $form */
        $form = $event->getForm();
        if (null === $form) {
            return;
        }

        $legal = $form->get('legal');
        if (!$legal->getData()) {
            $legal->addError(new FormError('You must accept terms and conditions'));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Subscription',
            'attr' => array(
                'id' => $this->getBlockPrefix()
            ),
            'custom_parameters' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'subscription_type';
    }

}