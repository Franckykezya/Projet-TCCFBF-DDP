<?php

namespace App\Entity;

use App\Repository\TauxInteretTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TauxInteretTypeRepository::class)
 */
class TauxInteretType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=TauxFixe::class, cascade={"persist", "remove"})
     */
    private $tauxfixe;

    /**
     * @ORM\OneToOne(targetEntity=TauxVariable::class, cascade={"persist", "remove"})
     */
    private $tauxvariable;

    public function getId(): ?int
    {
        return $this->id;
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
