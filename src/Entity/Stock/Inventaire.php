<?php

namespace App\Entity\Stock;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\Stock\InventaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventaireRepository::class)]
class Inventaire extends AbstractPrefixedIdEntity
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $dateHeur;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $valeurTotale;

    #[ORM\OneToMany(mappedBy: 'inventaire', targetEntity: DetailsInventaire::class, cascade: ['persist'])]
    private Collection $detailsInventaire;

    public function __construct()
    {
        $this->detailsInventaire = new ArrayCollection();
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

    public function getValeurTotale(): float
    {
        return $this->valeurTotale;
    }

    public function setValeurTotale(float $valeurTotale): static
    {
        $this->valeurTotale = $valeurTotale;

        return $this;
    }

    /**
     * @return Collection<int, DetailsInventaire>
     */
    public function getDetailsInventaire(): Collection
    {
        return $this->detailsInventaire;
    }

    public function addDetailsInventaire(DetailsInventaire $detailsInventaire): static
    {
        if (!$this->detailsInventaire->contains($detailsInventaire)) {
            $this->detailsInventaire[] = $detailsInventaire;
            $detailsInventaire->setInventaire($this);
        }

        return $this;
    }

    public function removeDetailsInventaire(DetailsInventaire $detailsInventaire): static
    {
        if ($this->detailsInventaire->removeElement($detailsInventaire)) {
            if ($detailsInventaire->getInventaire() === $this) {
                $detailsInventaire->setInventaire(null);
            }
        }

        return $this;
    }

    public function getPrefix(): string
    {
        return "INV";
    }

    public function getSequenceName(): string
    {
        return "ID_INVENTAIRE_SEQ";
    }
}
