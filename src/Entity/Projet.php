<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Validation formulaire
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 * @UniqueEntity(
 *     fields={"nom"},
 *     message="Cet projet exist dejà!!"
 * )
 */
class Projet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $part_finance;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Type(
     *          type="integer",
     *          message="Valeur invalide"
     * )
     */
    private $maturite_facilite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Type(
     *          type="integer",
     *          message="Valeur invalide"
     * )
     * @Assert\LessThan(
     *          propertyPath="maturite_facilite"
     * )
     */
    private $periode_grace;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $differentiel_interet;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $frais_gestion;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $commission_engagement;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $commission_service;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $commission_initiale;
   

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $commission_arrangement;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     */
    private $commission_agent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Type(
     *          type="integer",
     *          message="Valeur invalide"
     * )
     */
    private $maturite_lettre_credit;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $frais_lies_lettre_credit;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $frais_lies_refinancement;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     */
    private $frais_et_debours;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $prime_assurance_et_frais_garantie;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive(message = "Cette valeur doit être positive")
     * @Assert\Range(
     *          min=0,
     *          max=100, 
     *          notInRangeMessage = "Cette valeur doit être entre 0 et 100"
     * )
     */
    private $prime_attenuation_risque_credit;

    /**
     * @ORM\ManyToMany(targetEntity=SecteurIntervention::class, inversedBy="projets")
     */
    private $secteur;


    /**
     * @ORM\ManyToMany(targetEntity=TypeFinancement::class, inversedBy="projets")
     */
    private $typefinancement;
     /**
     * @ORM\ManyToMany(targetEntity=Bailleur::class, inversedBy="projets")
     */
    private $bailleur;

    /**
     * @ORM\Column(type="float")
     */
    private $elementdon;

    /**
     * @ORM\OneToOne(targetEntity=TauxFixe::class, cascade={"persist", "remove"})
     */
    private $tauxfixe;
        /**
     * @ORM\OneToOne(targetEntity=TauxVariable::class, cascade={"persist", "remove"})
     */
    private $tauxvariable;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $signature;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_mise_vigueur;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_limite_decaissement;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $situation;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $mo_monnaie;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $mo_montant;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $mo_equivalent_usd;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $de_montant_accord;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $de_equivalent_usd;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $de_taux;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $de_reste_decaisser;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $de_rest_decaisser_usd;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $de_montant_mga;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $di_montant_usd;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $di_date_notification;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $di_nature_depenses;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $di_situation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $pricipaux_problemes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $mesures_prises;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $concessionalite;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $statut;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observations;

    public function __construct()
    {
        $this->secteur = new ArrayCollection();
        $this->typefinancement = new ArrayCollection();
        $this->bailleur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPartFinance(): ?int
    {
        return $this->part_finance;
    }

    public function setPartFinance(int $part_finance): self
    {
        $this->part_finance = $part_finance;

        return $this;
    }

    public function getMaturiteFacilite(): ?int
    {
        return $this->maturite_facilite;
    }

    public function setMaturiteFacilite(int $maturite_facilite): self
    {
        $this->maturite_facilite = $maturite_facilite;

        return $this;
    }

    public function getPeriodeGrace(): ?int
    {
        return $this->periode_grace;
    }

    public function setPeriodeGrace(?int $periode_grace): self
    {
        $this->periode_grace = $periode_grace;

        return $this;
    }

    public function getDifferentielInteret(): ?float
    {
        return $this->differentiel_interet;
    }

    public function setDifferentielInteret(?float $differentiel_interet): self
    {
        $this->differentiel_interet = $differentiel_interet;

        return $this;
    }

    public function getFraisGestion(): ?float
    {
        return $this->frais_gestion;
    }

    public function setFraisGestion(?float $frais_gestion): self
    {
        $this->frais_gestion = $frais_gestion;

        return $this;
    }

    public function getCommissionEngagement(): ?float
    {
        return $this->commission_engagement;
    }

    public function setCommissionEngagement(?float $commission_engagement): self
    {
        $this->commission_engagement = $commission_engagement;

        return $this;
    }

    public function getCommissionService(): ?float
    {
        return $this->commission_service;
    }

    public function setCommissionService(?float $commission_service): self
    {
        $this->commission_service = $commission_service;

        return $this;
    }

    public function getCommissionInitiale(): ?float
    {
        return $this->commission_initiale;
    }

    public function setCommissionInitiale(?float $commission_initiale): self
    {
        $this->commission_initiale = $commission_initiale;

        return $this;
    }

    public function getCommissionArrangement(): ?float
    {
        return $this->commission_arrangement;
    }

    public function setCommissionArrangement(?float $commission_arrangement): self
    {
        $this->commission_arrangement = $commission_arrangement;

        return $this;
    }

    public function getCommissionAgent(): ?float
    {
        return $this->commission_agent;
    }

    public function setCommissionAgent(?float $commission_agent): self
    {
        $this->commission_agent = $commission_agent;

        return $this;
    }

    public function getMaturiteLettreCredit(): ?int
    {
        return $this->maturite_lettre_credit;
    }

    public function setMaturiteLettreCredit(int $maturite_lettre_credit): self
    {
        $this->maturite_lettre_credit = $maturite_lettre_credit;

        return $this;
    }

    public function getFraisLiesLettreCredit(): ?float
    {
        return $this->frais_lies_lettre_credit;
    }

    public function setFraisLiesLettreCredit(?float $frais_lies_lettre_credit): self
    {
        $this->frais_lies_lettre_credit = $frais_lies_lettre_credit;

        return $this;
    }

    public function getFraisLiesRefinancement(): ?float
    {
        return $this->frais_lies_refinancement;
    }

    public function setFraisLiesRefinancement(?float $frais_lies_refinancement): self
    {
        $this->frais_lies_refinancement = $frais_lies_refinancement;

        return $this;
    }

    public function getFraisEtDebours(): ?float
    {
        return $this->frais_et_debours;
    }

    public function setFraisEtDebours(?float $frais_et_debours): self
    {
        $this->frais_et_debours = $frais_et_debours;

        return $this;
    }

    public function getPrimeAssuranceEtFraisGarantie(): ?float
    {
        return $this->prime_assurance_et_frais_garantie;
    }

    public function setPrimeAssuranceEtFraisGarantie(?float $prime_assurance_et_frais_garantie): self
    {
        $this->prime_assurance_et_frais_garantie = $prime_assurance_et_frais_garantie;

        return $this;
    }

    public function getPrimeAttenuationRisqueCredit(): ?float
    {
        return $this->prime_attenuation_risque_credit;
    }

    public function setPrimeAttenuationRisqueCredit(?float $prime_attenuation_risque_credit): self
    {
        $this->prime_attenuation_risque_credit = $prime_attenuation_risque_credit;

        return $this;
    }

    /**
     * @return Collection|SecteurIntervention[]
     */
    public function getSecteur(): Collection
    {
        return $this->secteur;
    }

    public function addSecteur(SecteurIntervention $secteur): self
    {
        if (!$this->secteur->contains($secteur)) {
            $this->secteur[] = $secteur;
        }

        return $this;
    }

    public function removeSecteur(SecteurIntervention $secteur): self
    {
        $this->secteur->removeElement($secteur);

        return $this;
    }

    /**
     * @return Collection|TypeFinancement[]
     */
    public function getTypefinancement(): Collection
    {
        return $this->typefinancement;
    }

    public function addTypefinancement(TypeFinancement $typefinancement): self
    {
        if (!$this->typefinancement->contains($typefinancement)) {
            $this->typefinancement[] = $typefinancement;
        }

        return $this;
    }

    public function removeTypefinancement(TypeFinancement $typefinancement): self
    {
        $this->typefinancement->removeElement($typefinancement);

        return $this;
    }

    public function getElementdon(): ?float
    {
        return $this->elementdon;
    }

    public function setElementdon(float $elementdon): self
    {
        $this->elementdon = $elementdon;

        return $this;
    }
    // /**
    //  * @return Collection|Bailleur[]
    //  */
    // public function getBailleur(): Collection
    // {
    //     return $this->bailleur;
    // }

    // public function addBailleur(Bailleur $bailleur): self
    // {
    //     if (!$this->bailleur->contains($bailleur)) {
    //         $this->bailleur[] = $bailleur;
    //     }

    //     return $this;
    // }

    // public function removeBailleur(Bailleur $bailleur): self
    // {
    //     $this->bailleur->removeElement($bailleur);

    //     return $this;
    // } 
     /**
     * @return Collection|Bailleur[]
     */
    public function getBailleur(): Collection
    {
        return $this->bailleur;
    }

    public function addBailleur(Bailleur $bailleur): self
    {
        if (!$this->bailleur->contains($bailleur)) {
            $this->bailleur[] = $bailleur;
        }

        return $this;
    }

    public function removeBailleur(Bailleur $bailleur): self
    {
        $this->bailleur->removeElement($bailleur);

        return $this;
    }

    public function getTauxfixe(): ?TauxFixe
    {
        return $this->tauxfixe;
    }

    public function setTauxfixe(?TauxFixe $tauxfixe): self
    {
        $this->tauxfixe = $tauxfixe;

        return $this;
    }
    public function getTauxvariable(): ?TauxVariable
    {
        return $this->tauxvariable;
    }

    public function setTauxvariable(?TauxVariable $tauxvariable): self
    {
        $this->tauxvariable = $tauxvariable;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSignature(): ?\DateTimeInterface
    {
        return $this->signature;
    }

    public function setSignature(\DateTimeInterface $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getDateMiseVigueur(): ?\DateTimeInterface
    {
        return $this->date_mise_vigueur;
    }

    public function setDateMiseVigueur(?\DateTimeInterface $date_mise_vigueur): self
    {
        $this->date_mise_vigueur = $date_mise_vigueur;

        return $this;
    }

    public function getDateLimiteDecaissement(): ?\DateTimeInterface
    {
        return $this->date_limite_decaissement;
    }

    public function setDateLimiteDecaissement(?\DateTimeInterface $date_limite_decaissement): self
    {
        $this->date_limite_decaissement = $date_limite_decaissement;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSituation(): ?string
    {
        return $this->situation;
    }

    public function setSituation(string $situation): self
    {
        $this->situation = $situation;

        return $this;
    }

    public function getMoMonnaie(): ?string
    {
        return $this->mo_monnaie;
    }

    public function setMoMonnaie(string $mo_monnaie): self
    {
        $this->mo_monnaie = $mo_monnaie;

        return $this;
    }

    public function getMoMontant(): ?float
    {
        return $this->mo_montant;
    }

    public function setMoMontant(?float $mo_montant): self
    {
        $this->mo_montant = $mo_montant;

        return $this;
    }

    public function getMoEquivalentUsd(): ?float
    {
        return $this->mo_equivalent_usd;
    }

    public function setMoEquivalentUsd(?float $mo_equivalent_usd): self
    {
        $this->mo_equivalent_usd = $mo_equivalent_usd;

        return $this;
    }

    public function getDeMontantAccord(): ?float
    {
        return $this->de_montant_accord;
    }

    public function setDeMontantAccord(?float $de_montant_accord): self
    {
        $this->de_montant_accord = $de_montant_accord;

        return $this;
    }

    public function getDeEquivalentUsd(): ?float
    {
        return $this->de_equivalent_usd;
    }

    public function setDeEquivalentUsd(?float $de_equivalent_usd): self
    {
        $this->de_equivalent_usd = $de_equivalent_usd;

        return $this;
    }

    public function getDeTaux(): ?float
    {
        return $this->de_taux;
    }

    public function setDeTaux(?float $de_taux): self
    {
        $this->de_taux = $de_taux;

        return $this;
    }

    public function getDeResteDecaisser(): ?float
    {
        return $this->de_reste_decaisser;
    }

    public function setDeResteDecaisser(?float $de_reste_decaisser): self
    {
        $this->de_reste_decaisser = $de_reste_decaisser;

        return $this;
    }

    public function getDeRestDecaisserUsd(): ?float
    {
        return $this->de_rest_decaisser_usd;
    }

    public function setDeRestDecaisserUsd(?float $de_rest_decaisser_usd): self
    {
        $this->de_rest_decaisser_usd = $de_rest_decaisser_usd;

        return $this;
    }

    public function getDeMontantMga(): ?float
    {
        return $this->de_montant_mga;
    }

    public function setDeMontantMga(?float $de_montant_mga): self
    {
        $this->de_montant_mga = $de_montant_mga;

        return $this;
    }

    public function getDiMontantUsd(): ?float
    {
        return $this->di_montant_usd;
    }

    public function setDiMontantUsd(?float $di_montant_usd): self
    {
        $this->di_montant_usd = $di_montant_usd;

        return $this;
    }

    public function getDiDateNotification(): ?\DateTimeInterface
    {
        return $this->di_date_notification;
    }

    public function setDiDateNotification(?\DateTimeInterface $di_date_notification): self
    {
        $this->di_date_notification = $di_date_notification;

        return $this;
    }

    public function getDiNatureDepenses(): ?string
    {
        return $this->di_nature_depenses;
    }

    public function setDiNatureDepenses(?string $di_nature_depenses): self
    {
        $this->di_nature_depenses = $di_nature_depenses;

        return $this;
    }

    public function getDiSituation(): ?string
    {
        return $this->di_situation;
    }

    public function setDiSituation(?string $di_situation): self
    {
        $this->di_situation = $di_situation;

        return $this;
    }

    public function getPricipauxProblemes(): ?string
    {
        return $this->pricipaux_problemes;
    }

    public function setPricipauxProblemes(?string $pricipaux_problemes): self
    {
        $this->pricipaux_problemes = $pricipaux_problemes;

        return $this;
    }

    public function getMesuresPrises(): ?string
    {
        return $this->mesures_prises;
    }

    public function setMesuresPrises(?string $mesures_prises): self
    {
        $this->mesures_prises = $mesures_prises;

        return $this;
    }

    public function getConcessionalite(): ?string
    {
        return $this->concessionalite;
    }

    public function setConcessionalite(string $concessionalite): self
    {
        $this->concessionalite = $concessionalite;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }
    
}
