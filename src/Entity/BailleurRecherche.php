<?php

namespace App\Entity;

class BailleurRecherche
{
    /**
     * @var string|null
     */
    private $nombailleur;

    /**
     * @return string|null
     */
    public funcTion getNomBailleur(): ?string
    {
        return $this->nombailleur;
    }

    /**
     * @param string|null $nombailleur
     * @return BailleurRecherche
    */
    public function setNomBailleur(string $nombailleur): BailleurRecherche
    {
        $this->nombailleur = $nombailleur;
        return $this;
    }


}

