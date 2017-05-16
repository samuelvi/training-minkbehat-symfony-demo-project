<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email', 'text',
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
            'fullname', 'text',
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
            'subject', 'text',
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
            'message', 'textarea',
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
            'terms', 'checkbox',
            array(
                'label' => 'Accept terms and conditions *',
                'required' => true,
                'mapped' => true,
            )
        );

        $builder->add(
            'newsletter', 'checkbox',
            array(
                'label' => 'Subscribe to Newsletter *',
                'required' => false,
                'mapped' => true,
            )
        );

    }

    // Prevent bad data from entering the message attribute by filtering it
    public function setMessage($message) {
        $this->message = strip_tags($message);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Model\ContactDetail',
            'attr' => array(
                'id' => $this->getName()
            ),
            'custom_parameters' => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contact_form_type';
    }

}