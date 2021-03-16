<?php

namespace App\Form;

use App\Entity\TauxFixe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TauxFixeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('base',TextType::class)
            ->add('valeur',NumberType::class)
            ->add('valeur_element_don',NumberType::class,
            [
                'data' => 0
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TauxFixe::class,
        ]);
    }
}
