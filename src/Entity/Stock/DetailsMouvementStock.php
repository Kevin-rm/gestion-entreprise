<?php
<<<<<<< Updated upstream
 
 namespace App\Entity\Stock;

 use App\Entity\Generic\AbstractPrefixedIdEntity;
 use App\Entity\Annexe\Produit;
 use App\Repository\Stock\DetailsMouvementStockRepository;
 use Doctrine\ORM\Mapping as ORM;
 use Doctrine\DBAL\Types\Types;
 
 #[ORM\Entity(repositoryClass: DetailsMouvementStockRepository::class)]
 class DetailsMouvementStock extends AbstractPrefixedIdEntity
 {
     #[ORM\ManyToOne(targetEntity: MouvementStock::class, inversedBy: 'detailsMouvementStock')]
     private ?MouvementStock $mouvementStock = null;
 
     #[ORM\ManyToOne]
     #[ORM\JoinColumn(nullable: false)]
     private ?Produit $produit = null;
 
     #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
     private int $quantite;
 
     #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
     private float $prixUnitaire;
 
     public function getMouvementStock(): ?MouvementStock
     {
         return $this->mouvementStock;
     }
 
     public function setMouvementStock(?MouvementStock $mouvementStock): static
     {
         $this->mouvementStock = $mouvementStock;
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
 
     public function getQuantite(): int
     {
         return $this->quantite;
     }
 
     public function setQuantite(int $quantite): static
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
 
     public function getPrefix(): string
     {
         return "DETDMVTSTK";
     }
 
     public function getSequenceName(): string
     {
         return "ID_DETAILS_MOUVEMENT_STOCK_SEQ";
     }
 }
 

=======

namespace App\Entity\Stock;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Entity\Annexe\Produit;
use App\Repository\Stock\DetailsMouvementStockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsMouvementStockRepository::class)]
class DetailsMouvementStock extends AbstractPrefixedIdEntity
{
    #[ORM\ManyToOne(targetEntity: Produit::class)]
    #[ORM\JoinColumn(name: "id_produit", referencedColumnName: "id", nullable: false)]
    private ?Produit $produit = null;

    #[ORM\Column(type: 'float')]
    private float $quantite;

    #[ORM\ManyToOne(targetEntity: MouvementStock::class, inversedBy: 'details')]
    #[ORM\JoinColumn(name: "id_mouvement", referencedColumnName: "id", nullable: false)]
    private ?MouvementStock $mouvementStock = null;

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;
        return $this;
    }

    public function getQuantite(): float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): static
    {
        $this->quantite = $quantite;
        return $this;
    }

    public function getMouvementStock(): ?MouvementStock
    {
        return $this->mouvementStock;
    }

    public function setMouvementStock(?MouvementStock $mouvementStock): static
    {
        $this->mouvementStock = $mouvementStock;
        return $this;
    }

    public function getPrefix(): string
    {
        return "DETMVTSTK";
    }

    public function getSequenceName(): string
    {
        return "ID_DETAILS_MOUVEMENT_STOCK_SEQ";
    }
}
>>>>>>> Stashed changes
