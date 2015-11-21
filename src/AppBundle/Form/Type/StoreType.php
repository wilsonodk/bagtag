<?php
// src/AppBundle/Form/Type/StoreType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('required' => true))
            ->add('address', 'textarea', array('required' => false))
            ->add('city', 'text', array('required' => false))
            ->add('state', 'text', array('required' => false))
            ->add('zip', 'text', array('required' => false))
            ->add('phone', 'text', array('required' => false))
            ->add('email', 'text', array('required' => false))
            ->add('website', 'text', array('required' => false))
            ->add('facebook', 'text', array('required' => false))
            ->add('twitter', 'text', array('required' => false))
            ->add('youtube', 'text', array('required' => false))
            ->add('twitch', 'text', array('required' => false))
            ->add('save', 'submit')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Store',
        ));
    }

    public function getName()
    {
        return 'store';
    }
}
