<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
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
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $part_finance;

    /**
     * @ORM\Column(type="integer")
     */
    private $maturite_facilite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $periode_grace;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $differentiel_interet;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $frais_gestion;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $commission_engagement;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $commission_service;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $commission_initiale;
   

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $commission_arrangement;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $commission_agent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maturite_lettre_credit;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $frais_lies_lettre_credit;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $frais_lies_refinancement;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $frais_et_debours;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prime_assurance_et_frais_garantie;

    /**
     * @ORM\Column(type="float", nullable=true)
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
    
}
