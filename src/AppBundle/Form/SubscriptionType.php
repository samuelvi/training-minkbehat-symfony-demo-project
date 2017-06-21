<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
<<<<<<< HEAD
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
=======
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormError;

use AppBundle\Entity\Subscription;

class SubscriptionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email', 'text',
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
            array(
                'label'     => false,
                'required'  => true,
            )
        );

        $builder->add(
<<<<<<< HEAD
            'fullname', TextType::class,
=======
            'fullname', 'text',
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
            array(
                'label'     => false,
                'required'  => true,
            )
        );

        $builder->add(
<<<<<<< HEAD
            'legal', CheckboxType::class,
=======
            'legal', 'checkbox',
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
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
<<<<<<< HEAD
        /** @var FormInterface $form */
=======
        /** @var Form $form */
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
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
<<<<<<< HEAD
                'id' => $this->getBlockPrefix()
=======
                'id' => $this->getName()
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
            ),
            'custom_parameters' => null,
        ));
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getBlockPrefix()
=======

    /**
     * @return string
     */
    public function getName()
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
    {
        return 'subscription_type';
    }

}