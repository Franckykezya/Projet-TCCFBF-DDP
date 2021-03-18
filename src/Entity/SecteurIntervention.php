<?php

namespace App\Entity;

use App\Repository\SecteurInterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Validation formulaire
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SecteurInterventionRepository::class)
 * @UniqueEntity(
 *     fields={"nom"},
 *     message="Cet projet exist dejà!!"
 * )
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
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Projet::class, mappedBy="secteur")
     */
    private $projets;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
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
     * @return Collection|Projet[]
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): self
    {
        if (!$this->projets->contains($projet)) {
            $this->projets[] = $projet;
            $projet->addSecteur($this);
        }

        return $this;
    }

    public function removeProjet(projet $projet): self
    {
        if ($this->projets->removeElement($projet)) {
            $projet->removeSecteur($this);
        }

        return $this;
    }
}
