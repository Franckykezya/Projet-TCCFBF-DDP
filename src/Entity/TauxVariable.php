<?php

namespace App\Entity;

use App\Repository\TauxVariableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TauxVariableRepository::class)
 */
class TauxVariable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $base;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valeur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $marge;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Total;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valeur_element_don;

    /**
     * @ORM\Column(type="float")
     */
    private $valeur_calcul_element_don;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBase(): ?string
    {
        return $this->base;
    }

    public function setBase(?string $base): self
    {
        $this->base = $base;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(?float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getMarge(): ?float
    {
        return $this->marge;
    }

    public function setMarge(?float $marge): self
    {
        $this->marge = $marge;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->Total;
    }

    public function setTotal(?float $Total): self
    {
        $this->Total = $Total;

        return $this;
    }

    public function getValeurElementDon(): ?float
    {
        return $this->valeur_element_don;
    }

    public function setValeurElementDon(?float $valeur_element_don): self
    {
        $this->valeur_element_don = $valeur_element_don;

        return $this;
    }

    public function getValeurCalculElementDon(): ?float
    {
        return $this->valeur_calcul_element_don;
    }

    public function setValeurCalculElementDon(float $valeur_calcul_element_don): self
    {
        $this->valeur_calcul_element_don = $valeur_calcul_element_don;

        return $this;
    }
}
