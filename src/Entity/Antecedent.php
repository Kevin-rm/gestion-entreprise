<?php

namespace App\Entity;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\AntecedentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AntecedentRepository::class)]
class Antecedent extends AbstractPrefixedIdEntity
{
    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, Fournisseur>
     */
    #[ORM\ManyToMany(targetEntity: Fournisseur::class, mappedBy: 'antecedents')]
    private Collection $fournisseurs;

    public function __construct()
    {
        $this->fournisseurs = new ArrayCollection();
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
     * @return Collection<int, Fournisseur>
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): static
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->add($fournisseur);
            $fournisseur->addAntecedent($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): static
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            $fournisseur->removeAntecedent($this);
        }

        return $this;
    }

    function getPrefix(): string
    {
        return "ANT";
    }

    function getSequenceName(): string
    {
        return "ID_ANTECEDENT_SEQ";
    }
}
