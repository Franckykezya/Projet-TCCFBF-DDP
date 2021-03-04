<?php

namespace App\Form;

use App\Entity\TauxVariable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TauxVariableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('base',TextType::class)
            ->add('valeur',NumberType::class)
            ->add('valeur_calcul_element_don',NumberType::class)
            ->add('marge',NumberType::class)
            ->add('Total',NumberType::class)
            ->add('valeur_element_don',NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TauxVariable::class,
        ]);
    }
}
