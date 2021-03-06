<?php

namespace App\Form;

use App\Entity\Bailleur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BailleurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('siege')
            ->add('telephone')
            ->add('mail')
            ->add('fax')
            ->add('description')
            // ->add('projet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bailleur::class,
        ]);
    }
}
