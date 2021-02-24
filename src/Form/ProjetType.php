<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\SecteurIntervention;
use App\Entity\TypeFinancement;
use App\Entity\Bailleur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bailleur',EntityType::class, [
                'class' => Bailleur::class,
                 'choice_label' => 'nom',
                 'multiple' => true
            ])
            ->add('nom')
            ->add('part_finance')
            ->add('maturite_facilite')
            ->add('periode_grace')
            ->add('differentiel_interet')
            ->add('frais_gestion')
            ->add('commission_engagement')
            ->add('commission_service')
            ->add('commission_initiale')
            ->add('commission_arrangement')
            ->add('commission_agent')
            ->add('maturite_lettre_credit')
            ->add('frais_lies_lettre_credit')
            ->add('frais_lies_refinancement')
            ->add('frais_et_debours')
            ->add('prime_assurance_et_frais_garantie')
            ->add('prime_attenuation_risque_credit')
             ->add('secteur',EntityType::class, [
                 'class' => SecteurIntervention::class,
                  'choice_label' => 'nom',
                  'multiple' => true
             ])
             ->add('typefinancement',EntityType::class,[
                 'class' => TypeFinancement::class,
                 'choice_label' => 'nom',
                 'multiple' => true
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
