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
            ->add('valeur',NumberType::class,[
                'label' => "Valeur 1"
            ])
            ->add('valeur_calcul_element_don',NumberType::class,[
                'label' => "Valeur element don"
            ])
            ->add('marge',NumberType::class)
            ->add('Total',NumberType::class,[
                'disabled' => true,
                'label' => "TOTAL (Valeur 1 + Marge)"
            ])
            ->add('valeur_element_don',NumberType::class,[
                'disabled' => true,
                'label' => "TOTAL (Valeur element don + Marge)"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TauxVariable::class,
        ]);
    }
}
