<?php

namespace App\Entity;

use App\Repository\SecteurInterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SecteurInterventionRepository::class)
 */
class SecteurIntervention
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Bailleur::class, mappedBy="secteur")
     */
    private $bailleurs;

    public function __construct()
    {
        $this->bailleurs = new ArrayCollection();
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

    /**
     * @return Collection|Bailleur[]
     */
    public function getBailleurs(): Collection
    {
        return $this->bailleurs;
    }

    public function addBailleur(Bailleur $bailleur): self
    {
        if (!$this->bailleurs->contains($bailleur)) {
            $this->bailleurs[] = $bailleur;
            $bailleur->addSecteur($this);
        }

        return $this;
    }

    public function removeBailleur(Bailleur $bailleur): self
    {
        if ($this->bailleurs->removeElement($bailleur)) {
            $bailleur->removeSecteur($this);
        }

        return $this;
    }
}
