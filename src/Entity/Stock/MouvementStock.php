<?php

namespace App\Entity\Stock;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\Stock\MouvementStockRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Enum\TypeMouvementStock;

#[ORM\Entity(repositoryClass: MouvementStockRepository::class)]
class MouvementStock extends AbstractPrefixedIdEntity
{
    #[ORM\Column(enumType: TypeMouvementStock::class)]
    private ?TypeMouvementStock $typeMouvementStock = null; 

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $dateHeur;

    #[ORM\OneToMany(mappedBy: 'mouvementStock', targetEntity: DetailsMouvementStock::class, cascade: ['persist'])]
    private Collection $detailsMouvementStock;

    public function __construct()
    {
        $this->detailsMouvementStock = new ArrayCollection();
    }

    public function getTypeMouvementStock(): TypeMouvementStock
    {
        return $this->typeMouvementStock;
    }

    public function setTypeMouvementStock(TypeMouvementStock $typeMouvementStock): static
    {
        $this->typeMouvementStock = $typeMouvementStock;

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

    /**
     * @return Collection<int, DetailsMouvementStock>
     */
    public function getDetailsMouvementStock(): Collection
    {
        return $this->detailsMouvementStock;
    }

    public function addDetailsMouvementStock(DetailsMouvementStock $detailsMouvementStock): static
    {
        if (!$this->detailsMouvementStock->contains($detailsMouvementStock)) {
            $this->detailsMouvementStock[] = $detailsMouvementStock;
            $detailsMouvementStock->setMouvementStock($this);
        }

        return $this;
    }

    public function removeDetailsMouvementStock(DetailsMouvementStock $detailsMouvementStock): static
    {
        if ($this->detailsMouvementStock->removeElement($detailsMouvementStock)) {
            if ($detailsMouvementStock->getMouvementStock() === $this) {
                $detailsMouvementStock->setMouvementStock(null);
            }
        }

        return $this;
    }

    public function getPrefix(): string
    {
        return "MVTSTK";
    }

    public function getSequenceName(): string
    {
        return "ID_MOUVEMENT_STOCK_SEQ";
    }
}

