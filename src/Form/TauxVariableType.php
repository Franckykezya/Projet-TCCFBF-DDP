<?php

namespace App\Form;

use App\Entity\TauxVariable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TauxVariableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('base')
            ->add('valeur')
            ->add('valeur_calcul_element_don')
            ->add('marge')
            ->add('Total')
            ->add('valeur_element_don')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TauxVariable::class,
        ]);
    }
}
