<?php
namespace AppBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('steam', null, array('label' => 'Steam Profile', 'translation_domain' => 'FOSUserBundle'))
            ->add('twitch', null, array('label' => 'Twitch Profile', 'translation_domain' => 'FOSUserBundle'))
            ->add('facebook', null, array('label' => 'Facebook Profile', 'translation_domain' => 'FOSUserBundle'));
            
            
    }

    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }

}