<?php
// src/AppBundle/Form/Type/ChallengeType.php
namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('required' => true))
            ->add('players', 'entity', array(
                'class' => 'AppBundle:Player',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('hosted', 'date', array(
                'widget' => 'single_text',
                'placeholder' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'),
                'required' => false,
                'years' => range(2015, 2016),
            ))
            ->add('save', 'submit')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Challenge',
        ));
    }

    public function getName()
    {
        return 'challenge';
    }
}
