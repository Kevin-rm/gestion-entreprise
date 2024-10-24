<?php

namespace App\Entity\Achat;

use App\Entity\DocumentCommercial\AbstractDocumentCommercial;
use App\Entity\Tiers\Tiers;
use App\Repository\Achat\BonDeCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BonDeCommandeRepository::class)]
class BonDeCommande extends AbstractDocumentCommercial
{
    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_fournisseur", nullable: false)]
    private ?Tiers $fournisseur = null;

    /**
     * @var Collection<int, BonDeReception>
     */
    #[ORM\OneToMany(targetEntity: BonDeReception::class, mappedBy: 'bonDeCommande', orphanRemoval: true)]
    private Collection $bonDeReceptions;

    public function __construct()
    {
        parent::__construct();
        $this->bonDeReceptions = new ArrayCollection();
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getFournisseur(): ?Tiers
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Tiers $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * @return Collection<int, BonDeReception>
     */
    public function getBonDeReceptions(): Collection
    {
        return $this->bonDeReceptions;
    }

    public function addBonDeReception(BonDeReception $bonDeReception): static
    {
        if (!$this->bonDeReceptions->contains($bonDeReception)) {
            $this->bonDeReceptions->add($bonDeReception);
            $bonDeReception->setBonDeCommande($this);
        }

        return $this;
    }

    public function removeBonDeReception(BonDeReception $bonDeReception): static
    {
        if ($this->bonDeReceptions->removeElement($bonDeReception)) {
            // set the owning side to null (unless already changed)
            if ($bonDeReception->getBonDeCommande() === $this) {
                $bonDeReception->setBonDeCommande(null);
            }
        }

        return $this;
    }

    public function getPrefix(): string
    {
        return "BC";
    }

    public function getSequenceName(): string
    {
        return "ID_BON_DE_COMMANDE_SEQ";
    }
}
