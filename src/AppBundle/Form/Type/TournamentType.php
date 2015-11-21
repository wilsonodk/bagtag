<?php
// src/AppBundle/Form/Type/TournamentType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('required' => true))
            ->add('players', 'entity', array(
                'placeholder' => 'Pick players involved',
                'class' => 'AppBundle:Player',
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('hosted', 'date', array(
                'widget' => 'single_text',
                'placeholder' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'),
                'required' => false,
                'years' => range(2015,2016),
            ))
            ->add('save', 'submit')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tournament',
        ));
    }

    public function getName()
    {
        return 'tournament';
    }
}
