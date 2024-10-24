<?php

namespace App\Entity\Stock;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\Stock\MouvementStockRepository;
<<<<<<< Updated upstream
use Doctrine\ORM\Mapping as ORM;
=======
>>>>>>> Stashed changes
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\TypeMouvementStock;

#[ORM\Entity(repositoryClass: MouvementStockRepository::class)]
class MouvementStock extends AbstractPrefixedIdEntity
{
<<<<<<< Updated upstream
    #[ORM\Column(enumType: TypeMouvementStock::class)]
    private ?TypeMouvementStock $typeMouvementStock = null; 

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $dateHeur;

    #[ORM\OneToMany(mappedBy: 'mouvementStock', targetEntity: DetailsMouvementStock::class, cascade: ['persist'])]
    private Collection $detailsMouvementStock;
=======
    #[ORM\Column(type: 'string', enumType: TypeMouvementStock::class)]
    private ?TypeMouvementStock $typeMouvementStock = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateHeure = null;

    #[ORM\OneToMany(mappedBy: 'mouvementStock', targetEntity: DetailsMouvementStock::class, cascade: ['persist'])]
    private Collection $details;
>>>>>>> Stashed changes

    public function __construct()
    {
        $this->detailsMouvementStock = new ArrayCollection();
    }

    public function getTypeMouvementStock(): ?TypeMouvementStock
    {
        return $this->typeMouvementStock;
    }

    public function setTypeMouvementStock(TypeMouvementStock $typeMouvementStock): static
    {
        $this->typeMouvementStock = $typeMouvementStock;
        return $this;
    }

<<<<<<< Updated upstream
    public function getDateHeur(): \DateTimeInterface
=======
    public function getDateHeure(): ?\DateTimeInterface
>>>>>>> Stashed changes
    {
        return $this->dateHeur;
    }

    public function setDateHeur(\DateTimeInterface $dateHeur): static
    {
<<<<<<< Updated upstream
        $this->dateHeur = $dateHeur;

=======
        $this->dateHeure = $dateHeure;
>>>>>>> Stashed changes
        return $this;
    }

    /**
     * @return Collection<int, DetailsMouvementStock>
     */
    public function getDetailsMouvementStock(): Collection
    {
        return $this->detailsMouvementStock;
    }

<<<<<<< Updated upstream
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

=======
>>>>>>> Stashed changes
    public function getPrefix(): string
    {
        return "MVTSTK";
    }

    public function getSequenceName(): string
    {
        return "ID_MOUVEMENT_STOCK_SEQ";
    }
}

