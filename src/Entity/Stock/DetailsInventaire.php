<?php

namespace App\Entity\Stock;

use App\Repository\Stock\DetailsInventaireRepository;
use App\Entity\Annexe\Produit;
use App\Entity\Generic\AbstractPrefixedIdEntity;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: DetailsInventaireRepository::class)]
class DetailsInventaire extends AbstractPrefixedIdEntity
{

    #[ORM\ManyToOne(targetEntity: Inventaire::class, inversedBy: 'detailsInventaire')]
    private ?Inventaire $inventaire = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_produit", nullable: false)]
    private ?Produit $produit = null;

    #[ORM\Column]
    private ?float $quantite = null;


    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $prixUnitaire;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $dateHeur;

    public function getInventaire(): ?Inventaire
    {
        return $this->inventaire;
    }

    public function setInventaire(?Inventaire $inventaire): static
    {
        $this->inventaire = $inventaire;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantite():float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaire(): float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getDateHeur(): \DateTimeInterface
    {
        return $this->dateHeur;
    }

    public function setDateHeur(\DateTimeInterface $dateHeur): static
    {
        $this->dateHeur = $dateHeur;

        return $this;
    }

    public function getPrefix(): string
    {
        return "DETINV";
    }

    public function getSequenceName(): string
    {
        return "ID_DETAILS_INVENTAIRE_SEQ";
    }
}
