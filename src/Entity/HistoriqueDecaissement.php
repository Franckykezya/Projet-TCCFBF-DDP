<?php

namespace App\Entity;

use App\Repository\HistoriqueDecaissementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueDecaissementRepository::class)
 */
class HistoriqueDecaissement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $hi_date;

    /**
     * @ORM\Column(type="float")
     */
    private $hi_montant_accord;

    /**
     * @ORM\Column(type="float")
     */
    private $hi_equivalent_usd;

    /**
     * @ORM\Column(type="float")
     */
    private $hi_taux;

    /**
     * @ORM\Column(type="float")
     */
    private $hi_reste_decaisser;

    /**
     * @ORM\Column(type="float")
     */
    private $hi_reste_decaisser_usd;

    /**
     * @ORM\ManyToOne(targetEntity=Projet::class, inversedBy="historiqueDecaissements")
     */
    private $projet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHiDate(): ?\DateTimeInterface
    {
        return $this->hi_date;
    }

    public function setHiDate(\DateTimeInterface $hi_date): self
    {
        $this->hi_date = $hi_date;

        return $this;
    }

    public function getHiMontantAccord(): ?float
    {
        return $this->hi_montant_accord;
    }

    public function setHiMontantAccord(float $hi_montant_accord): self
    {
        $this->hi_montant_accord = $hi_montant_accord;

        return $this;
    }

    public function getHiEquivalentUsd(): ?float
    {
        return $this->hi_equivalent_usd;
    }

    public function setHiEquivalentUsd(float $hi_equivalent_usd): self
    {
        $this->hi_equivalent_usd = $hi_equivalent_usd;

        return $this;
    }

    public function getHiTaux(): ?float
    {
        return $this->hi_taux;
    }

    public function setHiTaux(float $hi_taux): self
    {
        $this->hi_taux = $hi_taux;

        return $this;
    }

    public function getHiResteDecaisser(): ?float
    {
        return $this->hi_reste_decaisser;
    }

    public function setHiResteDecaisser(float $hi_reste_decaisser): self
    {
        $this->hi_reste_decaisser = $hi_reste_decaisser;

        return $this;
    }

    public function getHiResteDecaisserUsd(): ?float
    {
        return $this->hi_reste_decaisser_usd;
    }

    public function setHiResteDecaisserUsd(float $hi_reste_decaisser_usd): self
    {
        $this->hi_reste_decaisser_usd = $hi_reste_decaisser_usd;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }
}
