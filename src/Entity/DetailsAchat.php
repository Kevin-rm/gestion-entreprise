<?php

namespace App\Entity;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\DetailsAchatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsAchatRepository::class)]
class DetailsAchat extends AbstractPrefixedIdEntity
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_produit", nullable: false)]
    private ?Produit $produit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prixUnitaire = null;

    #[ORM\Column]
    private ?float $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'detailsAchats')]
    #[ORM\JoinColumn(name: "id_demande_achat", nullable: false)]
    private ?DemandeAchat $demandeAchat = null;

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

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

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDemandeAchat(): ?DemandeAchat
    {
        return $this->demandeAchat;
    }

    public function setDemandeAchat(?DemandeAchat $demandeAchat): static
    {
        $this->demandeAchat = $demandeAchat;

        return $this;
    }

    function getPrefix(): string
    {
        return "DETACHT";
    }

    function getSequenceName(): string
    {
        return "ID_DETAILS_ACHAT_SEQ";
    }
}
