<?php

namespace App\Entity;

use App\Repository\BailleurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Validation formulaire
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BailleurRepository::class)
 * @UniqueEntity(
 *     fields={"nom"},
 *     message="Cet bailleur exist dejà!!"
 * )
 */
class Bailleur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Projet::class, mappedBy="bailleur")
     */
    private $projets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siege;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min = 8, max = 20, minMessage = "trop court", maxMessage = "trop long")
     * @Assert\Regex(pattern="/^\+?[0-9]*$/", message="nombre seulement")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "{{ value }}' n'est pas un e-mail valide."
     * )
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min = 8, max = 20, minMessage = "trop court", maxMessage = "trop long")
     * @Assert\Regex(pattern="/^\+?[0-9]*$/", message="nombre seulement")
     */
    private $fax;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Projet[]
     */
    public function getProjet(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): self
    {
        if (!$this->projets->contains($projet)) {
            $this->projet[] = $projet;
            $projet->addBailleur($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): self
    {
        if($this->projets->removeElement($projet)){
            $projet->removeBailleur($this);
        }
        

        return $this;
    }

    public function getSiege(): ?string
    {
        return $this->siege;
    }

    public function setSiege(string $siege): self
    {
        $this->siege = $siege;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }
}
