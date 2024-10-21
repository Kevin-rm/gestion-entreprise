<?php
 
namespace App\Entity\Stock;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Entity\Annexe\Produit;
use App\Repository\Stock\DetailsMouvementStockRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: DetailsMouvementStockRepository::class)]
class DetailsMouvementStock extends AbstractPrefixedIdEntity
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_produit", nullable: false)]
    private ?Produit $produit = null;

    #[ORM\Column]
    private ?float $quantite = null;

    #[ORM\ManyToOne(targetEntity: MouvementStock::class, inversedBy: 'detailsMouvementStock')]
    #[JoinColumn(name: "id_mouvement", nullable: false)]
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

    public function getQuantite(): ?float
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
