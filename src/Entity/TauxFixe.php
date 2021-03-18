<?php

namespace App\Entity;

use App\Repository\TauxFixeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

// Validation formulaire
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TauxFixeRepository::class)
 */
class TauxFixe
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
     * 
     */
    private $valeur_element_don;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
    }
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

    public function getValeurElementDon(): ?float
    {
        return $this->valeur_element_don;
    }

    public function setValeurElementDon(?float $valeur_element_don): self
    {
        $this->valeur_element_don = $valeur_element_don;

        return $this;
    }
   
}
