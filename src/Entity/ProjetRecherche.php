<?php

namespace App\Entity;

class ProjetRecherche
{
    /**
     * @var string|null
     */
    private $nomprojet;

    /**
     * @return string|null
     */
    public funcTion getNomProjet(): ?string
    {
        return $this->nomprojet;
    }

    /**
     * @param string|null $nomprojet
     * @return ProjetRecherche
    */
    public function setNomProjet(string $nomprojet): ProjetRecherche
    {
        $this->nomprojet = $nomprojet;
        return $this;
    }


}

