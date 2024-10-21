<?php

namespace App\Entity\Stock;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\Stock\MouvementStockRepository;
use Doctrine\DBAL\Types\Types;
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
    private ?\DateTimeInterface $dateHeure = null;

    #[ORM\OneToMany(targetEntity: DetailsMouvementStock::class, mappedBy: 'mouvementStock', cascade: ['persist'])]
    private Collection $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
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

    public function getDateHeure(): \DateTimeInterface
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTimeInterface $dateHeure): static
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    /**
     * @return Collection<int, DetailsMouvementStock>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetails(DetailsMouvementStock $detailsMouvementStock): static
    {
        if (!$this->details->contains($detailsMouvementStock)) {
            $this->details[] = $detailsMouvementStock;
            $detailsMouvementStock->setMouvementStock($this);
        }

        return $this;
    }

    public function removeDetails(DetailsMouvementStock $detailsMouvementStock): static
    {
        if ($this->details->removeElement($detailsMouvementStock)) {
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
