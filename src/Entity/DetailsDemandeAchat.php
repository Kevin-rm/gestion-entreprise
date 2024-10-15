<?php

namespace App\Entity;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\DetailsDemandeAchatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsDemandeAchatRepository::class)]
class DetailsDemandeAchat extends AbstractPrefixedIdEntity
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_produit", nullable: false)]
    private ?Produit $produit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $coutUnitaireEstime = null;

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

    public function getCoutUnitaireEstime(): ?string
    {
        return $this->coutUnitaireEstime;
    }

    public function setCoutUnitaireEstime(string $coutUnitaireEstime): static
    {
        $this->coutUnitaireEstime = $coutUnitaireEstime;

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
        return "DETDMDACHT";
    }

    function getSequenceName(): string
    {
        return "ID_DETAILS_DEMANDE_ACHAT_SEQ";
    }
}
