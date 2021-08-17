<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\SecteurIntervention;
use App\Entity\TypeFinancement;
use App\Entity\Bailleur;
use App\Entity\TauxFixe;
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
             ->add('tauxfixe',TauxFixeType::class)
             ->add('tauxvariable',TauxVariableType::class,
             [
                 'required' => false
             ]
             )

             // New
             ->add('description')
             ->add('signature')
             ->add('date_mise_vigueur')
             ->add('date_limite_decaissement')
             ->add('type')
             ->add('situation')
             ->add('mo_monnaie')
             ->add('mo_montant')
             ->add('mo_equivalent_usd')
             ->add('de_montant_accord')
            //  ->add('de_equivalent_usd')
            //  ->add('de_taux')
            //  ->add('de_reste_decaisser')
            //  ->add('de_rest_decaisser_usd')
             ->add('de_montant_mga')
             ->add('di_montant_usd')
             ->add('di_date_notification')
             ->add('di_nature_depenses')
             ->add('di_situation')
             ->add('pricipaux_problemes')
             ->add('mesures_prises')
             ->add('concessionalite')
             ->add('statut')
             ->add('observations')

                     ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
