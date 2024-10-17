<?php

namespace App\Entity\Tiers;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\Tiers\AntecedentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AntecedentRepository::class)]
class Antecedent extends AbstractPrefixedIdEntity
{
    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, Tiers>
     */
    #[ORM\ManyToMany(targetEntity: Tiers::class, mappedBy: 'antecedents')]
    private Collection $tiers;

    public function __construct()
    {
        $this->tiers = new ArrayCollection();
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Tiers>
     */
    public function getTiers(): Collection
    {
        return $this->tiers;
    }

    public function addTiers(Tiers $tiers): static
    {
        if (!$this->tiers->contains($tiers)) {
            $this->tiers->add($tiers);
            $tiers->addAntecedent($this);
        }

        return $this;
    }

    public function removeTiers(Tiers $tiers): static
    {
        if ($this->tiers->removeElement($tiers)) {
            $tiers->removeAntecedent($this);
        }

        return $this;
    }

    public function getPrefix(): string
    {
        return "ANTE";
    }

    public function getSequenceName(): string
    {
        return "ID_ANTECEDENT_SEQ";
    }
}
