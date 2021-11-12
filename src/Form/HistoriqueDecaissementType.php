<?php

namespace App\Form;

use App\Entity\HistoriqueDecaissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoriqueDecaissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hi_date')
            ->add('hi_montant_accord')
            //->add('hi_equivalent_usd')
            //->add('hi_taux')
            //->add('hi_reste_decaisser')
            //->add('hi_reste_decaisser_usd')
            //->add('projet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HistoriqueDecaissement::class,
        ]);
    }
}
