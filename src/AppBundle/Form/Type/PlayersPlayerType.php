<?php
// src/AppBundle/Form/Type/PlayersPlayerType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayersPlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => true,
                'attr' => array(
                    'readonly' => true
                ),
            ))
            ->add('rank', 'integer', array('required' => true))
            ->add('active', 'checkbox', array('required' => false))
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
        return 'players_player';
    }
}
