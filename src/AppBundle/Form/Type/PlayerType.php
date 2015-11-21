<?php
// src/AppBundle/Form/Type/PlayerType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Get stores

        $builder
            ->add('name', 'text', array('required' => true))
            ->add('rank', 'integer', array('required' => true))
            ->add('stores', 'entity', array(
                'placeholder' => 'Choose a store or stores',
                'class' => 'AppBundle:Store',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => true,
            ))
            ->add('save', 'submit')
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Player',
        ));
    }

    public function getName()
    {
        return 'player';
    }
}
