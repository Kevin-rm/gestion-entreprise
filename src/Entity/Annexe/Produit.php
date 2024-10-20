<?php

namespace App\Entity\Annexe;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\Annexe\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit extends AbstractPrefixedIdEntity
{
    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_unite")]
    private ?Unite $unite = null;

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getUnite(): ?Unite
    {
        return $this->unite;
    }

    public function setUnite(?Unite $unite): static
    {
        $this->unite = $unite;

        return $this;
    }

    public function getPrefix(): string
    {
        return "PROD";
    }

    public function getSequenceName(): string
    {
        return "ID_PRODUIT_SEQ";
    }
}
