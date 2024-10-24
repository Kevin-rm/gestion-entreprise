<?php

namespace App\Entity\DocumentCommercial;

use App\Entity\Annexe\Produit;
use App\Entity\Generic\AbstractPrefixedIdEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class DetailsDocumentCommercial extends AbstractPrefixedIdEntity
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_produit", nullable: false)]
    private ?Produit $produit = null;

    #[ORM\Column]
    private ?float $quantite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prixUnitaire = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private ?string $tva = null;

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaire(): ?string
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(string $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public abstract function getDocumentCommercial(): ?AbstractDocumentCommercial;

    public abstract function setDocumentCommercial(?AbstractDocumentCommercial $documentCommercial): static;
}
