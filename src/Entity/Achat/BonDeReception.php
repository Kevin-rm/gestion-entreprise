<?php

namespace App\Entity\Achat;

use App\Entity\DocumentCommercial\AbstractDocumentCommercial;
use App\Repository\Achat\BonDeReceptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BonDeReceptionRepository::class)]
class BonDeReception extends AbstractDocumentCommercial
{
    #[ORM\ManyToOne(inversedBy: 'bonDeReceptions')]
    #[ORM\JoinColumn(name: "id_bon_de_commande", nullable: false)]
    private ?BonDeCommande $bonDeCommande = null;

    /**
     * @var Collection<int, DetailsBonDeReception>
     */
    #[ORM\OneToMany(targetEntity: DetailsBonDeReception::class, mappedBy: 'bonDeReception', orphanRemoval: true)]
    private Collection $detailsBonDeReceptions;

    public function __construct()
    {
        parent::__construct();
        $this->detailsBonDeReceptions = new ArrayCollection();
    }

    public function getBonDeCommande(): ?BonDeCommande
    {
        return $this->bonDeCommande;
    }

    public function setBonDeCommande(?BonDeCommande $bonDeCommande): static
    {
        $this->bonDeCommande = $bonDeCommande;

        return $this;
    }

    /**
     * @return Collection<int, DetailsBonDeReception>
     */
    public function getDetailsBonDeReceptions(): Collection
    {
        return $this->detailsBonDeReceptions;
    }

    public function addDetailsBonDeReception(DetailsBonDeReception $detailsBonDeReception): static
    {
        if (!$this->detailsBonDeReceptions->contains($detailsBonDeReception)) {
            $this->detailsBonDeReceptions->add($detailsBonDeReception);
            $detailsBonDeReception->setDocumentCommercial($this);
        }

        return $this;
    }

    public function removeDetailsBonDeReception(DetailsBonDeReception $detailsBonDeReception): static
    {
        if ($this->detailsBonDeReceptions->removeElement($detailsBonDeReception)) {
            // set the owning side to null (unless already changed)
            if ($detailsBonDeReception->getDocumentCommercial() === $this) {
                $detailsBonDeReception->setDocumentCommercial(null);
            }
        }

        return $this;
    }

    public function getPrefix(): string
    {
        return "BR";
    }

    public function getSequenceName(): string
    {
        return "ID_BON_DE_RECEPTION_SEQ";
    }
}
