<?php

namespace App\Entity\DocumentCommercial;

use App\Entity\Annexe\Produit;
use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\DocumentCommercial\DetailsDocumentCommercialRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsDocumentCommercialRepository::class)]
class DetailsDocumentCommercial extends AbstractPrefixedIdEntity
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

    #[ORM\ManyToOne(inversedBy: 'details')]
    #[ORM\JoinColumn(name: "document_commercial", nullable: false)]
    private ?AbstractDocumentCommercial $documentCommercial = null;

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

    public function getDocumentCommercial(): ?AbstractDocumentCommercial
    {
        return $this->documentCommercial;
    }

    public function setDocumentCommercial(?AbstractDocumentCommercial $documentCommercial): static
    {
        $this->documentCommercial = $documentCommercial;

        return $this;
    }

    public function getPrefix(): string
    {
        return "DETDC";
    }

    public function getSequenceName(): string
    {
        return "ID_DETAILS_DOCUMENT_COMMERCIAL_SEQ";
    }
}
