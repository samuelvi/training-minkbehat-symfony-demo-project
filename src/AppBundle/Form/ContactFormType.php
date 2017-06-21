<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
<<<<<<< HEAD
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
=======
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
<<<<<<< HEAD
            'email', TextType::class,
=======
            'email', 'text',
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
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
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
<<<<<<< HEAD
            'subject', TextType::class,
=======
            'subject', 'text',
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
<<<<<<< HEAD
            'message', TextareaType::class,
=======
            'message', 'textarea',
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
            array(
                'label'     => false,
                'required'  => true, // Do not trust browser, for demo purposes
            )
        );

        $builder->add(
<<<<<<< HEAD
            'terms', CheckboxType::class,
=======
            'terms', 'checkbox',
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
            array(
                'label' => 'Accept terms and conditions *',
                'required' => true,
                'mapped' => true,
            )
        );

        $builder->add(
<<<<<<< HEAD
            'newsletter', CheckboxType::class,
=======
            'newsletter', 'checkbox',
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
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
<<<<<<< HEAD
                'id' => $this->getBlockPrefix()
=======
                'id' => $this->getName()
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
            ),
            'custom_parameters' => null,
        ));
    }

    /**
     * @return string
     */
<<<<<<< HEAD
    public function getBlockPrefix()
=======
    public function getName()
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
    {
        return 'contact_form_type';
    }

}